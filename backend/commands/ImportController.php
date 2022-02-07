<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\catalog\NcBrand;
use app\models\catalog\NcModel;
use app\models\catalog\NcProductGroup;
use app\models\catalog\NcProductType;
use app\models\catalog\NcSeries;
use app\models\eparts\service\EpBrand;
use app\models\eparts\service\EpProductLine;
use app\models\eparts\service\EpProductModel;
use app\models\eparts\service\EpProductSeries;
use app\models\eparts\service\EpProductType;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ImportController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
//        $this->importBrand();
//        $this->importTypes();
//        $this->importProductLines();
//        $this->importProductSeries();
        $this->importProductModels();
    }


    private function importBrand()
    {
        $data = EpBrand::find()->select(['ep_id', 'name', 'created_at', 'updated_at'])->asArray()->all();
        NcBrand::getDb()->createCommand()->batchInsert(
            NcBrand::tableName(),
            ['id', 'name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }

    private function importTypes()
    {
        $data = EpProductType::find()
            ->alias('pt')
            ->rightJoin('ep_brand AS b', 'pt.brand_id = b.id')
            ->select(['pt.id', 'pt.ep_id AS external_id', 'b.ep_id AS brand_id', 'pt.description', 'pt.created_at', 'pt.updated_at'])->asArray()->all();

        NcProductType::getDb()->createCommand()->batchInsert(
            NcProductType::tableName(),
            ['id', 'external_id', 'brand_id', 'name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }

    private function importProductLines()
    {
        $data = EpProductLine::find()
            ->alias('pl')
//            ->rightJoin('ep_product_type AS pt', 'pl.type_id = pt.id')
            ->select(['pl.id', 'pl.ep_id', 'pl.type_id', 'pl.description', 'pl.created_at', 'pl.updated_at'])->asArray()->all();

        NcProductGroup::getDb()->createCommand()->batchInsert(
            NcProductGroup::tableName(),
            ['id', 'external_id', 'product_type_id', 'name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }

    private function importProductSeries()
    {
        $data = EpProductSeries::find()
            ->alias('ps')
//            ->rightJoin('ep_product_type AS pt', 'pl.type_id = pt.id')
            ->select(['ps.id', 'ps.ep_id', 'ps.type_id', 'ps.description', 'ps.created_at', 'ps.updated_at'])
            ->asArray()
            ->all();

        NcSeries::getDb()->createCommand()->batchInsert(
            NcSeries::tableName(),
            ['id', 'external_id', 'product_group_id', 'name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }


    private function importProductModels()
    {
        $data = EpProductModel::find()
            ->alias('pm')
//            ->rightJoin('ep_product_type AS pt', 'pl.type_id = pt.id')
            ->select(['pm.id', 'pm.ep_id', 'pm.series_id', 'pm.description', 'pm.created_at', 'pm.updated_at'])
            ->asArray()
            ->all();

        NcModel::getDb()->createCommand()->batchInsert(
            NcModel::tableName(),
            ['id', 'external_id', 'series_id', 'name', 'created_at', 'updated_at'],
            $data
        )->execute();
    }
}
