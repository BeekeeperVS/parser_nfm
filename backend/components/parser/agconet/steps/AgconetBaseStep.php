<?php

namespace components\parser\agconet\steps;

use components\parser\enum\ParserEnum;
use yii\base\BaseObject;
use yii\db\ActiveRecord;
use yii\helpers\Json;

abstract class AgconetBaseStep extends BaseObject implements AgconetStepInterface
{
    use ParentInstanseTait;

    public string $action;
    public ActiveRecord $model;

    protected string $parserName = ParserEnum::AGCONET_PARSER;

    protected string $stepTitle;
    private string $dataModelClass;
    private string $apiMethod;
    public array $response;

    public function __construct($config = [])
    {
        foreach ($config as $params => $value) {
            switch ($params) {
                case 'stepTitle':
                case 'dataModelClass':
                case 'apiMethod':
                    $this->{$params} = $value;
                    unset($config[$params]);
                    break;
            }
        }
        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (!isset($this->dataModelClass)) return;

        $this->model = $this->isChild ? $this->getParentInstance() : $this->dataModelClass::findOne(['status_parser' => STATUS_PARSER_NEW]);

        if ($this->isParen && !empty($this->model)) {
            $this->setParentInstance($this->stepTitle, $this->model);
        }
    }

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
    public function getResponse(): array
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
     * @param string $modelClassName
     * @return void
     */
    protected function setDataModel(string $modelClassName)
    {
        $this->dataModelClass = $modelClassName;
    }

    protected function setStepTitle(string $stepTitle)
    {
        $this->stepTitle = $stepTitle;
    }

    /**
     * @return array
     */
    protected function sendRequest()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_HOST') . env('API_AGCONET_CONTROLLER') . $this->getApiMethod(),
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
        return [
            'bearerToken' => \Yii::$app->params['agconetConfig']['bearerToken'],
        ];
    }

    /**
     * @param string|null $param
     * @return array|string|null
     */
    protected function getResponseParam(?string $param): array|string|null
    {
        switch (true) {
            case empty($param):
                return $this->response['data'];
            case isset($this->response['data'][$param]):
                return $this->response['data'][$param];
            default:
                return null;
        }
    }


}