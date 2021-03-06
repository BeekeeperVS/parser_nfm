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
        for($i = 1; $i <= 1000; $i++) {
            print_r("$i...");
            $parserFactory = new ParserFactory();
            $parser = $parserFactory->make(ParserEnum::EPARTS_PARSER);
            $parser->run(ActionEPartsEnum::PARSER_CATALOG_ACTION);

        }

        print_r("\n");
    }
}