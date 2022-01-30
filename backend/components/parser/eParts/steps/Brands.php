<?php

namespace components\parser\eParts\steps;

use yii\helpers\Json;

class Brands extends EPartsBaseStep
{
    /** @var string $userId */
    public $userId;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_HOST").env('API_EPART_CONTROLLER').'/brands',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => Json::encode([
                "userId" => $this->userId
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            print_r("cURL Error #:" . $err);
        } else {
            print_r($response);
            $brandsList = Json::decode($response)['brands'];
            $batchParams = [];
            foreach ($brandsList as $item) {
                $batchParams[] = [$item['brandId'], $item['brandName'], $item['brandCode']];
            }
            \Yii::$app->db->createCommand()->batchInsert('{{%ep_brand}}', ['ep_id', 'name' ,'code'], $brandsList)->execute();
        }
    }

}