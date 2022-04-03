<?php

namespace app\commands;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\ActionAgconetEnum;
use components\parser\agconet\enum\StepAgconetEnum;
use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\ActionEPartsEnum;
use components\parser\exception\ParserException;
use components\parser\factory\ParserFactory;
use components\parser\factory\ParserFactoryInterface;

class AgconetParserController extends \yii\console\Controller
{

    private ParserFactoryInterface $parserFactory;

    /**
     * @param $id
     * @param $module
     * @param ParserFactoryInterface $parserFactory
     * @param $config
     */
    public function __construct($id, $module, ParserFactoryInterface $parserFactory, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->parserFactory = $parserFactory;
    }

    /**
     * @return void
     * @throws ParserException
     */
    public function actionStart()
    {
        $parser = $this->parserFactory->make(ParserEnum::AGCONET_PARSER);
        $parser->run(ActionAgconetEnum::PARSER_CATALOG_ACTION);
    }

    public function actionLogin()
    {
        ParserStep::setNew(ParserEnum::AGCONET_PARSER, ActionAgconetEnum::PARSER_CATALOG_ACTION, StepAgconetEnum::LOGIN_STEP);
    }
}