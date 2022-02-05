<?php

namespace components\parser\eParts\steps\factory;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpBrand;
use app\models\eparts\service\EpProductType;
use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\StepEpartsEnum;
use components\parser\eParts\steps\AssemblyDetails;
use components\parser\eParts\steps\AssemblyParts;
use components\parser\eParts\steps\Authorization;
use components\parser\eParts\steps\Brands;
use components\parser\eParts\steps\EPartsStepInterface;
use components\parser\eParts\steps\ModelAssemblies;
use components\parser\eParts\steps\ModelFunctionlGroups;
use components\parser\eParts\steps\PartDetails;
use components\parser\eParts\steps\PartKits;
use components\parser\eParts\steps\PartSubstitutions;
use components\parser\eParts\steps\ProductLines;
use components\parser\eParts\steps\ProductModels;
use components\parser\eParts\steps\ProductSeries;
use components\parser\eParts\steps\ProductTypes;
use components\parser\exception\ParserException;

class EPartsStepParserFactory implements EPartsStepParserFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function makeStep(string $action, string $stepName, array $config = []): EPartsStepInterface
    {
        $stepList = $this->stepList();
        if (isset($stepList[$stepName])) {
            ParserStep::active(ParserEnum::EPARTS_PARSER, $action, $stepName);
            $config['class'] = $stepList[$stepName];
            $config['action'] = $action;
            return \Yii::createObject($config);
        } else {
            ParserException::stepNotFound(ParserEnum::EPARTS_PARSER, 'unknown', $stepName);
        }
    }

    /**
     * @return string[]
     */
    private function stepList(): array
    {
        return [
            StepEpartsEnum::LOGIN_STEP => Authorization::class,
            StepEpartsEnum::BRANDS_STEP => Brands::class,
            StepEpartsEnum::PRODUCT_TYPES_STEP => ProductTypes::class,
            StepEpartsEnum::PRODUCT_LINES_STEP => ProductLines::class,
            StepEpartsEnum::PRODUCT_SERIES_STEP => ProductSeries::class,
            StepEpartsEnum::PRODUCT_MODELS_STEP => ProductModels::class,
            StepEpartsEnum::MODEL_FUNCTIONAL_GROUPS_STEP => ModelFunctionlGroups::class,
            StepEpartsEnum::MODEL_ASSEMBLIES_STEP => ModelAssemblies::class,
            StepEpartsEnum::ASSEMBLY_DETAILS_STEP => AssemblyDetails::class,
            StepEpartsEnum::ASSEMBLY_PARTS_STEP => AssemblyParts::class,
            StepEpartsEnum::PART_DETAILS_STEP => PartDetails::class,
            StepEpartsEnum::PART_SUBSTITUTIONS_STEP => PartSubstitutions::class,
            StepEpartsEnum::PART_KITS_STEP => PartKits::class
        ];
    }

    private function makeConfig(string $stepName): array
    {
        switch ($stepName) {
            case StepEpartsEnum::PRODUCT_TYPES_STEP:
                break;
            case StepEpartsEnum::PRODUCT_LINES_STEP:
                $type= EpProductType::findOne(['status_parser' => STATUS_PARSER_NEW]);
                $config = [
                    'brandId' => 1,
                    'epBrandId' => 2,
                    'typeId' => 9,
                    'epTypeId' => 'EU_B_M'
                ];
                break;
            case StepEpartsEnum::PRODUCT_SERIES_STEP:
                $brand = EpBrand::findOne(['status_parser' => STATUS_PARSER_NEW]);
                $config = [
                    'brandId' => $brand->id,
                    'epBrandId' => $brand->ep_id
                ];
                break;
            case StepEpartsEnum::LOGIN_STEP:
            case StepEpartsEnum::BRANDS_STEP:
            default:
                $config = [];

        }

        return $config;
    }
}