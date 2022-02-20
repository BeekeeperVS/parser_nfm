<?php

namespace components\parser\agconet\steps\factory;

use components\parser\agconet\steps\AgconetStepInterface;
use components\parser\exception\ParserException;

interface AgconetStepParserFactoryInterface
{
    /**
     * @param string $action
     * @param string $stepName
     * @param array $config
     * @return AgconetStepInterface
     * @throws ParserException
     * @throws \yii\base\InvalidConfigException
     */
    public function makeStep(string $action, string $stepName, array $config = []): AgconetStepInterface;
}