<?php

namespace components\parser\agconet\steps\factory;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;
use components\parser\agconet\steps\AgconetStepInterface;
use components\parser\agconet\steps\BrandItem;
use components\parser\agconet\steps\CatalogPats;
use components\parser\agconet\steps\ModelGroups;
use components\parser\agconet\steps\Models;
use components\parser\agconet\steps\ModelSchemes;
use components\parser\agconet\steps\Schemes;
use components\parser\enum\ParserEnum;
use components\parser\agconet\steps\Authorization;
use components\parser\agconet\steps\Brands;
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
            StepAgconetEnum::SCHEMES_STEP => Schemes::class
        ];
    }

}