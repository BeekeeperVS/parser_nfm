<?php

namespace components\parser\agconet\steps;

use app\models\common\service\ParserStep;
use app\service\fileGenerate\PhpConfigFileGenerateService;
use components\parser\agconet\enum\StepAgconetEnum;

class Authorization extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('login');
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
//        print_r('ddddd');die;
        parent::run();

        if ($this->isSuccess()) {
            $cookies = $this->getResponseParam('cookies');
            $phpGenerate = new PhpConfigFileGenerateService();
            $phpGenerate->put('cookies', $cookies);
            $phpGenerate->install('parserConfig.php', \Yii::getAlias("@config"));
        }
    }
}