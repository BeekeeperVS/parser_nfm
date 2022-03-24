<?php

namespace components\parser\agconet\steps\factory;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpBrand;
use app\models\eparts\service\EpProductType;
use components\parser\agconet\enum\StepAgconetEnum;
use components\parser\agconet\steps\AgconetStepInterface;
use components\parser\agconet\steps\BrandItem;
use components\parser\agconet\steps\CatalogPats;
use components\parser\agconet\steps\ModelGroups;
use components\parser\agconet\steps\Models;
use components\parser\agconet\steps\ModelSchemes;
use components\parser\agconet\steps\SchemeDetail;
use components\parser\agconet\steps\Schemes;
use components\parser\enum\ParserEnum;
use components\parser\agconet\steps\AssemblyDetails;
use components\parser\agconet\steps\AssemblyParts;
use components\parser\agconet\steps\Authorization;
use components\parser\agconet\steps\Brands;
use components\parser\agconet\steps\EPartsStepInterface;
use components\parser\agconet\steps\ModelAssemblies;
use components\parser\agconet\steps\ModelFunctionlGroups;
use components\parser\agconet\steps\PartDetails;
use components\parser\agconet\steps\PartKits;
use components\parser\agconet\steps\PartSubstitutions;
use components\parser\agconet\steps\ProductLines;
use components\parser\agconet\steps\ProductModels;
use components\parser\agconet\steps\ProductSeries;
use components\parser\agconet\steps\ProductTypes;
use components\parser\exception\ParserException;

class AgconetStepParserFactory implements AgconetStepParserFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function makeStep(string $action, string $stepName, array $config = []): AgconetStepInterface
    {
        $stepList = $this->stepList();
        if (isset($stepList[$stepName])) {
            ParserStep::active(ParserEnum::AGCONET_PARSER, $action, $stepName);
            $config['class'] = $stepList[$stepName];
            $config['action'] = $action;
            return \Yii::createObject($config);
        } else {
            ParserException::stepNotFound(ParserEnum::AGCONET_PARSER, 'unknown', $stepName);
        }
    }

    /**
     * @return string[]
     */
    private function stepList(): array
    {
        return [
            StepAgconetEnum::LOGIN_STEP => Authorization::class,
            StepAgconetEnum::BRANDS_STEP => Brands::class,
            StepAgconetEnum::BRAND_ITEM_STEP => BrandItem::class,
            StepAgconetEnum::CATALOG_PATS_STEP => CatalogPats::class,
            StepAgconetEnum::MODEL_GROUPS_STEP => ModelGroups::class,
            StepAgconetEnum::MODELS_STEP => Models::class,
            StepAgconetEnum::MODEL_SCHEMES_STEP => ModelSchemes::class,
            StepAgconetEnum::SCHEMES_STEP => Schemes::class,
            StepAgconetEnum::SCHEME_DETAIL_STEP => SchemeDetail::class,
//            StepAgconetEnum::ASSEMBLY_DETAILS_STEP => AssemblyDetails::class,
//            StepAgconetEnum::ASSEMBLY_PARTS_STEP => AssemblyParts::class,
//            StepAgconetEnum::PART_DETAILS_STEP => PartDetails::class,
//            StepAgconetEnum::PART_SUBSTITUTIONS_STEP => PartSubstitutions::class,
//            StepAgconetEnum::PART_KITS_STEP => PartKits::class
        ];
    }

    private function makeConfig(string $stepName): array
    {
        switch ($stepName) {
            case StepAgconetEnum::PRODUCT_TYPES_STEP:
                break;
            case StepAgconetEnum::PRODUCT_LINES_STEP:
                $type= EpProductType::findOne(['status_parser' => STATUS_PARSER_NEW]);
                $config = [
                    'brandId' => 1,
                    'epBrandId' => 2,
                    'typeId' => 9,
                    'epTypeId' => 'EU_B_M'
                ];
                break;
            case StepAgconetEnum::PRODUCT_SERIES_STEP:
                $brand = EpBrand::findOne(['status_parser' => STATUS_PARSER_NEW]);
                $config = [
                    'brandId' => $brand->id,
                    'epBrandId' => $brand->ep_id
                ];
                break;
            case StepAgconetEnum::LOGIN_STEP:
            case StepAgconetEnum::BRANDS_STEP:
            default:
                $config = [];

        }

        return $config;
    }
}