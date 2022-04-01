<?php

namespace components\parser\agconet\actions;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;
use components\parser\agconet\steps\factory\AgconetStepParserFactory;
use components\parser\exception\ParserException;

final class ParserCatalogAction extends AgconetBaseAction
{
    public const ACTION_TITLE = 'catalog';

    /**
     * @return void
     * @throws ParserException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $stepFactory = new AgconetStepParserFactory();
        $parserStep = ParserStep::find()->currentStep();
        $isParent = !empty($parserStep->childSteps);
        if (!empty($parserStep)) {
            $stepParser = $stepFactory->makeStep(self::ACTION_TITLE, $parserStep->title, ['isParen' => $isParent]);
            $stepParser->run();
            if ($isParent) {
                foreach ($parserStep->childSteps as $childStep) {
                    $childStepParser = $stepFactory->makeStep(self::ACTION_TITLE, $childStep->title, ['isChild' => true, 'parentStep' => $childStep->parent_step]);
                    $childStepParser->run();
                }
            }
        } else {
            print_r("Agconet COMPLETE\n");
        }
    }

    /**
     * @return array
     */
    public static function orderStepParser(): array
    {
        return [
            [
                'step' => StepAgconetEnum::LOGIN_STEP,
                'parentStep' => null,
                'sortOrder' => 1
            ],
            [
                'step' => StepAgconetEnum::BRANDS_STEP,
                'parentStep' => null,
                'sortOrder' => 2
            ],
            [
                'step' => StepAgconetEnum::BRAND_ITEM_STEP,
                'parentStep' => null,
                'sortOrder' => 3
            ],
            [
                'step' => StepAgconetEnum::CATALOG_PATS_STEP,
                'parentStep' => StepAgconetEnum::BRAND_ITEM_STEP,
                'sortOrder' => 4
            ],
            [
                'step' => StepAgconetEnum::MODEL_GROUPS_STEP,
                'parentStep' => null,
                'sortOrder' => 5
            ],
            [
                'step' => StepAgconetEnum::MODELS_STEP,
                'parentStep' => null,
                'sortOrder' => 6
            ],
            [
                'step' => StepAgconetEnum::MODEL_SCHEMES_STEP,
                'parentStep' => null,
                'sortOrder' => 7
            ],
            [
                'step' => StepAgconetEnum::SCHEMES_STEP,
                'parentStep' => StepAgconetEnum::MODEL_SCHEMES_STEP,
                'sortOrder' => 8
            ],
            [
                'step' => StepAgconetEnum::SCHEME_DETAIL_STEP,
                'parentStep' => null,
                'sortOrder' => 9
            ]
        ];
    }
}