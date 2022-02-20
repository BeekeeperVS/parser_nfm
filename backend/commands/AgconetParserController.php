<?php

namespace app\commands;

use components\parser\agconet\enum\ActionAgconetEnum;
use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\ActionEPartsEnum;
use components\parser\exception\ParserException;
use components\parser\factory\ParserFactory;

class AgconetParserController extends \yii\console\Controller
{
    /**
     * @return void
     * @throws ParserException
     */
    public function actionTest() {
        $parserFactory = new ParserFactory();
        $parser = $parserFactory->make(ParserEnum::AGCONET_PARSER);
        $parser->run(ActionAgconetEnum::PARSER_CATALOG_ACTION);

        print_r("\n");
    }
}