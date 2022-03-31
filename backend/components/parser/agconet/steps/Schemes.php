<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class Schemes extends AgconetBaseStep
{
    private string $stepTitle = StepAgconetEnum::SCHEMES_STEP;
    protected ?Brand $model;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('schemes');
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
            'brandTitle' => 'generalpublications',
            'modelId' => 4820992110,
            'tocGuid' => 'bf03b76a-fd7a-774f-354d-f9db0ba593a0'
        ]);
    }

}