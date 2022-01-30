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
        $stepParser = $stepFactory->makeStep(
            StepEpartsEnum::PRODUCT_TYPES_STEP,
            [
                'brandId' => 2
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