<?php

namespace components\parser\eParts\actions;

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


        $stepParser = $stepFactory->makeStep(
            StepEpartsEnum::PRODUCT_LINES_STEP,
            [
                'brandId' => 1,
                'epBrandId' => 2,
                'typeId' => 9,
                'epTypeId' => 'EU_B_M'
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