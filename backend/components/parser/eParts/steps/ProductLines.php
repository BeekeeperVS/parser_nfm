<?php

namespace components\parser\eParts\steps;

use yii\helpers\Json;

class ProductLines extends EPartsBaseStep
{
    public const API_METHOD = '/product-lines';

    public int $brandId;
    public int $epBrandId;
    public int $typeId;
    public string $epTypeId;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_HOST") . env('API_EPART_CONTROLLER') . self::API_METHOD,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => Json::encode([
                'brandId' => $this->epBrandId,
                'productTypeId' => $this->epTypeId

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
            $brandsList = Json::decode($response)['productLines'];
            $batchParams = [];
            foreach ($brandsList as $item) {

                $batchParams[] = [$this->typeId, $item['productLineId'], $item['productLineDescription']];
            }
            \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_line}}', ['type_id', 'ep_id', 'description'], $batchParams)->execute();
        }
    }
}