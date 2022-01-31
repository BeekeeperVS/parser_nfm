<?php

namespace components\parser\eParts\steps;

use JetBrains\PhpStorm\Pure;
use yii\base\BaseObject;
use yii\helpers\Json;

abstract class EPartsBaseStep extends BaseObject implements EPartsStepInterface
{
    private string $apiMethod;

    private array $response;

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        $this->sendRequest();
    }

    /**
     * @return bool
     */
    protected function isSuccess(): bool
    {
        $response = $this->getResponse();
        return (isset($response['status']) && $response['status']);
    }

    /**
     * @return array
     */
    protected function getResponse(): array
    {
        return $this->response ?? [];
    }

    /**
     * @param array $response
     * @return void
     */
    protected function setResponse(array $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    protected function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    /**
     * @param string $apiMethod
     */
    protected function setApiMethod(string $apiMethod): void
    {
        $this->apiMethod = '/' . $apiMethod;
    }

    /**
     * @return array
     */
    protected function sendRequest()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_HOST') . env('API_EPART_CONTROLLER') . $this->getApiMethod(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => Json::encode($this->makeDataRequest()),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            $this->setResponse(['status' => false, 'msg' => 'cURL Error #:' . $error]);
        } else {
            $this->setResponse(Json::decode($response));
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [];
    }

    /**
     * @param string $param
     * @return array|null
     */
    protected function getResponseParam(string $param): ?array
    {
        return $this->response[$param] ?? null;
    }


}