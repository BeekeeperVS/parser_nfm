<?php

namespace app\commands;

use components\parser\factory\ParserFactory;

class ParserController extends \yii\console\Controller
{
    public function actionTest() {
        $parserFactory = new ParserFactory();
        $parser = $parserFactory->make();
        $result = $parser->run();
        print_r($result);
        print_r("\n");
    }
}