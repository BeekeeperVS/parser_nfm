<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use app\models\agconet\service\Scheme;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property Scheme $model
 */
class SchemeDetail extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::SCHEME_DETAIL_STEP,
            'dataModelClass' => Scheme::class,
            'apiMethod' => '/scheme-detail'
        ]));
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if (!empty($this->model)) {

            $this->model->status_parser = STATUS_PARSER_ACTIVE;
            $this->model->save();

            try {
                parent::run();
                $isErrorParser = false;
            } catch (\Throwable $e) {
                $isErrorParser = true;
            }

            if (!$isErrorParser && $this->isSuccess()) {
                $this->model->status_parser = STATUS_PARSER_COMPLETE;

            } else {
                $this->model->status_parser = STATUS_PARSER_ERROR;
            }
            $this->model->save();
        } else {
            ParserStep::complete($this->parserName, $this->action, $this->stepTitle);
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return array_merge(parent::makeDataRequest(), [
            'brandTitle' => $this->model->model->site_id,//'generalpublications',
            'modelId' => $this->model->model->book_id,//4820992110,
            'schemeId' => $this->model->site_id,
            'tocGuid' => $this->model->key//'bf03b76a-fd7a-774f-354d-f9db0ba593a0'
        ]);
    }
}