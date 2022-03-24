<?php

namespace components\parser\agconet\steps;

use app\models\common\service\ParserStep;
use app\service\fileGenerate\PhpConfigFileGenerateService;
use components\parser\agconet\enum\StepAgconetEnum;

class Models extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('models');
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
            'brandTitle' => myUrlEncode('general publications'),
            'categoryId' => '013261fc4d392f89be9b68f2ed0b27e2'
        ]);
    }
}