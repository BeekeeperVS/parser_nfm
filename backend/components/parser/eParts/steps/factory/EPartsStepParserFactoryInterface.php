<?php

namespace components\parser\eParts\steps\factory;

use components\parser\exception\ParserException;

interface EPartsStepParserFactoryInterface
{
    /**
     * @param string $action
     * @param string $stepName
     * @param array $config
     * @return \components\parser\eParts\steps\EPartsStepInterface
     * @throws ParserException
     * @throws \yii\base\InvalidConfigException
     */
    public function makeStep(string $action, string $stepName, array $config = []): \components\parser\eParts\steps\EPartsStepInterface;
}