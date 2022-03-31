<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class ModelGroups extends AgconetBaseStep
{
    private string $stepTitle = StepAgconetEnum::MODEL_GROUPS_STEP;
    protected ?Brand $model;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('model-groups');
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
            'brandTitle' => myUrlEncode('general publications'),
            'categoryId' => '1dd2b039c0b9233051cde35dd6bde392'
        ]);
    }
}