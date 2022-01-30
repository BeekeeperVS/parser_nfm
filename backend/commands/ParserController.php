<?php

namespace app\commands;

use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\ActionEPartsEnum;
use components\parser\factory\ParserFactory;

class ParserController extends \yii\console\Controller
{
    /**
     * @return void
     * @throws \components\parser\exception\ParserException
     */
    public function actionTest() {
        $parserFactory = new ParserFactory();
        $parser = $parserFactory->make(ParserEnum::EPARTS_PARSER);
        $parser->run(ActionEPartsEnum::PARSER_CATALOG_ACTION);

        print_r("\n");
    }
}