<?php

namespace components\parser\eParts\actions;

use app\models\eparts\EpAssembly;
use app\models\eparts\EpModelFunctionalGroup;
use components\parser\eParts\enum\StepEpartsEnum;
use components\parser\eParts\steps\factory\EPartsStepParserFactory;

final class ParserCatalogAction extends EPartsBaseAction
{

    /**
     * @return void
     * @throws \components\parser\exception\ParserException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $stepFactory = new EPartsStepParserFactory();
//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::BRANDS_STEP,
//            []
//        );


//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::PRODUCT_TYPES_STEP,
//            [
//                'brandId' => 2,
//                'interiorBrandId' => 1
//            ]
//        );


//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::PRODUCT_LINES_STEP,
//            [
//                'brandId' => 1,
//                'epBrandId' => 2,
//                'typeId' => 9,
//                'epTypeId' => 'EU_B_M'
//            ]
//        );


//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::PRODUCT_LINES_STEP,
//            [
//                'brandId' => 1,
//                'epBrandId' => 2,
//                'typeId' => 9,
//                'epTypeId' => 'EU_B_M'
//            ]
//        );

//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::PRODUCT_SERIES_STEP,
//            [
//                'brandId' => 1,
//                'typeId' =>  9,
//                'lineId' => 4,
//                'epBrandId' => 2,
//                'epTypeId' => 'EU_B_M',
//                'epLineId' => 'EU_B_M_33_FOR'
//            ]
//        );


//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::PRODUCT_MODELS_STEP,
//            [
//                'brandId' => 1,
//                'typeId' =>  9,
//                'lineId' => 4,
//                'seriesId' => 1,
//                'epBrandId' => 2,
//                'epTypeId' => 'EU_B_M',
//                'epLineId' => 'EU_B_M_33_FOR',
//                'epSeriesId' => 'EU_B_M_33_FOR_095_675'
//            ]
//        );

//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::MODEL_FUNCTIONAL_GROUPS_STEP,
//            [
//                'brandId' => 1,
//                'modelId' =>  9,
//                'epBrandId' => 2,
//                'epModelId' => '22F9724F-E6BE-E111-9FCE-005056875BD6',
//            ]
//        );

//        $modelFunctionalGroup = EpModelFunctionalGroup::findOne(1);
//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::MODEL_ASSEMBLIES_STEP,
//            [
//                'brandId' => $modelFunctionalGroup->productModel->type->brand->id,
//                'modelId' => $modelFunctionalGroup->productModel->id,
//                'epBrandId' => $modelFunctionalGroup->productModel->type->brand->ep_id,
//                'epModelId' => $modelFunctionalGroup->productModel->ep_id,
//                'epFunctionalGroupId' => $modelFunctionalGroup->functionalGroup->ep_id,
//                'epIsTechnicalTypeDriven' => $modelFunctionalGroup->productModel->is_technical_type_driven
//            ]
//        );

//        $assembly = EpAssembly::findOne(1);
//        $stepParser = $stepFactory->makeStep(
//            StepEpartsEnum::ASSEMBLY_DETAILS_STEP,
//            [
//                'brandId' => $assembly->modelFunctionalGroup->productModel->type->brand->id,
//                'modelId' => $assembly->modelFunctionalGroup->productModel->id,
//                'assemblyId' => $assembly->id,
//                'epBrandId' => $assembly->modelFunctionalGroup->productModel->type->brand->ep_id,
//                'epModelId' => $assembly->modelFunctionalGroup->productModel->ep_id,
//                'epAssemblyId' => $assembly->ep_id,
//                'epIsTechnicalTypeDriven' => $assembly->modelFunctionalGroup->productModel->is_technical_type_driven
//            ]
//        );

        $assembly = EpAssembly::findOne(3);
        $stepParser = $stepFactory->makeStep(
            StepEpartsEnum::ASSEMBLY_PARTS_STEP,
            [
                'brandId' => $assembly->modelFunctionalGroup->productModel->type->brand->id,
                'modelId' => $assembly->modelFunctionalGroup->productModel->id,
                'assemblyId' => $assembly->id,
                'epBrandId' => $assembly->modelFunctionalGroup->productModel->type->brand->ep_id,
                'epModelId' => $assembly->modelFunctionalGroup->productModel->ep_id,
                'epAssemblyId' => $assembly->ep_id,
                'epIsTechnicalTypeDriven' => $assembly->modelFunctionalGroup->productModel->is_technical_type_driven,
                'functionalGroupId' => $assembly->modelFunctionalGroup->functionalGroup->id,
                'epFunctionalGroupId' => $assembly->modelFunctionalGroup->functionalGroup->ep_id,
            ]
        );


        $stepParser->run();

    }

    private function orderStepParser(): array
    {
        return [

        ];
    }
}