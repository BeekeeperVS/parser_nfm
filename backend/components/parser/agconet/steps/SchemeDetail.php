<?php

namespace components\parser\agconet\steps;

use app\models\common\service\ParserStep;
use app\service\fileGenerate\PhpConfigFileGenerateService;
use components\parser\agconet\enum\StepAgconetEnum;

class SchemeDetail extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('scheme-detail');
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            print_r($this->getResponse());
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return array_merge(parent::makeDataRequest(), [
            'brandTitle' => 'generalpublications',
            'modelId' => 4820992110,
            'schemeId' => 2795168,
            'tocGuid' => 'bf03b76a-fd7a-774f-354d-f9db0ba593a0'
        ]);
    }
}