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

    public function actionIdx()
    {


        $cookies = '';
        foreach (\Yii::$app->params['parserConfig']['cookies'] as $item) {
            $cookies .= "$item[name]=$item[value]; ";
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://net.agcocorp.com/agconet/ZMAIN.ASPX?ID=idx001&NR=139&B=agco',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'authorization:SAPISIDHASH 1645447395_53506a4e761d8c1a4df8d405e029636a1493e5b0_u',
                'Cookie: '.$cookies
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
}