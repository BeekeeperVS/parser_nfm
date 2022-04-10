<?php

namespace app\models\common\service\import;

use app\models\agconet\service\Brand;
use app\models\agconet\service\Model;
use app\models\agconet\service\ModelGroup;
use app\models\agconet\service\PartsBook;
use app\models\agconet\service\Scheme;
use app\models\catalog\NcBrand;
use app\models\catalog\NcModel;
use app\models\catalog\NcProductGroup;
use app\models\catalog\NcProductType;
use app\models\catalog\NcScheme;
use app\models\catalog\NcSeries;

/**
 * 1) Brands        => Brands
 * 2) CatalogPats(PartBooks) => ProductTypes
 * 3) ModelCroup    => ProductGroups
 *                  => Series
 * 4) Models        => Models
 * 5) Schemes (l1, l2, l3-schema) (l3)=> Scheme
 *                  => Lines = NULL
 * 6) Parts         => Part
 * 7) Scheme && Parts => SchemePart
 */
class ImportAgconetSrvice implements ImportInterface
{

    public function import()
    {
//        $this->importBrand();
//        $this->importTypes();
//        $this->importProductGroup();
//        $this->importProductSeries();
        $this->importModels();
    }

    private function importBrand()
    {
        $data = Brand::find()->select(['name', 'created_at', 'updated_at'])->asArray()->all();
        NcBrand::getDb()->createCommand()->batchInsert(
            NcBrand::tableName(),
            ['name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }

    private function importTypes()
    {
        $data = PartsBook::find()
            ->alias('pb')
            ->rightJoin('agc_brand AS b', 'pb.brand_id = b.id')
            ->select(['pb.id', 'pb.key AS external_id', 'b.name AS brand_name', 'pb.name', 'pb.created_at', 'pb.updated_at'])->asArray()->all();

        $brandsData = NcBrand::find()->select(['id', 'name'])->asArray()->all();
        $brands = [];
        foreach ($brandsData as $item) {
            $brands[$item['name']] = $item['id'];
        }
        $batchInsert = [];
        foreach ($data as $key => $item) {
            if (empty($item['id'])) continue;
            $batchInsert[] = [
                $item['external_id'], $brands[$item['brand_name']], $item['name'], $item['created_at'], $item['updated_at']
            ];
        }

        NcProductType::getDb()->createCommand()->batchInsert(
            NcProductType::tableName(),
            ['external_id', 'brand_id', 'name', 'created_at', 'updated_at'],
            $batchInsert
        )->execute();
    }

    private function importProductGroup()
    {
        $data = ModelGroup::find()
            ->alias('mg')
            ->rightJoin('agc_parts_book AS pb', 'mg.parts_book_id = pb.id')
            ->select(['mg.id', 'mg.key as external_id', 'pb.key as parts_book_key', 'mg.name', 'mg.created_at', 'mg.updated_at'])->asArray()->all();

        $joinData = NcProductType::find()->select(['id', 'external_id'])->asArray()->all();

        foreach ($joinData as $key => $item) {
            $joinData[$item['external_id']] = $item['id'];
            unset($joinData[$key]);
        }

        $batchInsert = [];
        foreach ($data as $key => $item) {
            if (empty($item['id'])) continue;
            $batchInsert[] = [
                $item['external_id'], $joinData[$item['parts_book_key']], $item['name'], $item['created_at'], $item['updated_at']
            ];
        }

        NcProductGroup::getDb()->createCommand()->batchInsert(
            NcProductGroup::tableName(),
            ['external_id', 'product_type_id', 'name', 'created_at', 'updated_at'],
            $batchInsert
        )->execute();
    }

    private function importProductSeries()
    {
        $data = ModelGroup::find()
            ->alias('mg')
            ->rightJoin('agc_parts_book AS pb', 'mg.parts_book_id = pb.id')
            ->select(['mg.id', 'mg.key as external_id', 'pb.key as parts_book_key', 'mg.name', 'mg.created_at', 'mg.updated_at'])->asArray()->all();

        $joinData = NcProductGroup::find()->select(['id', 'external_id'])->asArray()->all();

        foreach ($joinData as $key => $item) {
            $joinData[$item['external_id']] = $item['id'];
            unset($joinData[$key]);
        }

        $batchInsert = [];
        foreach ($data as $key => $item) {
            if (empty($item['id'])) continue;
            $batchInsert[] = [
                $item['external_id'], $joinData[$item['external_id']], $item['name'], $item['created_at'], $item['updated_at']
            ];
        }


        NcSeries::getDb()->createCommand()->batchInsert(
            NcSeries::tableName(),
            ['external_id', 'product_group_id', 'name', 'created_at', 'updated_at'],
            $batchInsert
        )->execute();
    }

    private function importModels()
    {
        $data = Model::find()
            ->alias('m')
            ->rightJoin('agc_model_group AS mg', 'm.model_id = mg.id')
            ->select(['m.id', 'm.key as external_id', 'mg.key as series_key', 'm.name', 'm.created_at', 'm.updated_at'])->asArray()->all();

        $joinData = NcSeries::find()->select(['id', 'external_id'])->asArray()->all();

        foreach ($joinData as $key => $item) {
            $joinData[$item['external_id']] = $item['id'];
            unset($joinData[$key]);
        }

        $batchInsert = [];
        foreach ($data as $key => $item) {
            if (empty($item['id'])) continue;
            $batchInsert[] = [
                $item['external_id'], $joinData[$item['series_key']], $item['name'], $item['created_at'], $item['updated_at']
            ];
        }

        NcModel::getDb()->createCommand()->batchInsert(
            NcModel::tableName(),
            ['external_id', 'series_id', 'name', 'created_at', 'updated_at'],
            $batchInsert
        )->execute();
    }

    private function importScheme()
    {
        $data = Scheme::find()
            ->alias('sch')
            ->rightJoin('agc_modelAS m', 'sch.model_id = m.id')
            ->select(['sch.id', 'sch.key as external_id', 'm.key as model_key', 'sch.name', 'sch.image_url', 'sch.created_at', 'sch.updated_at'])
            ->where(['level' => 3])
            ->asArray()->all();

        $joinData = NcModel::find()->select(['id', 'external_id'])->asArray()->all();

        foreach ($joinData as $key => $item) {
            $joinData[$item['external_id']] = $item['id'];
            unset($joinData[$key]);
        }

        $batchInsert = [];
        foreach ($data as $key => $item) {
            if (empty($item['id'])) continue;
            $batchInsert[] = [
                $item['external_id'], $joinData[$item['model_key']], $item['name'], $item['image_url'], $item['created_at'], $item['updated_at']
            ];
        }

        NcScheme::getDb()->createCommand()->batchInsert(
            NcModel::tableName(),
            ['external_id', 'model', 'name', 'created_at', 'updated_at'],
            $batchInsert
        )->execute();
    }
}