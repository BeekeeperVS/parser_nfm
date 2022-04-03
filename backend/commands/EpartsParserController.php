<?php

namespace app\commands;

use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\ActionEPartsEnum;
use components\parser\exception\ParserException;
use components\parser\factory\ParserFactory;
use components\parser\factory\ParserFactoryInterface;

class EpartsParserController extends \yii\console\Controller
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
    public function actionStart() {
        $parser = $this->parserFactory->make(ParserEnum::EPARTS_PARSER);
        $parser->run(ActionEPartsEnum::PARSER_CATALOG_ACTION);
    }
}