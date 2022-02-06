<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpFunctionalGroup;
use app\models\eparts\service\EpProductModel;
use components\parser\eParts\enum\StepEpartsEnum;

class ModelFunctionlGroups extends EPartsBaseStep
{
    private string $stepTitle = StepEpartsEnum::MODEL_FUNCTIONAL_GROUPS_STEP;

    protected ?EpProductModel $model;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('model-functional-groups');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if (!empty($this->model)) {

            $this->model->status_parser = STATUS_PARSER_ACTIVE;
            $this->model->save();
            try {

                try {
                    parent::run();
                    $isErrorParser = false;
                } catch (\Throwable $e) {
                    $isErrorParser = true;
                }

                if (!$isErrorParser && $this->isSuccess()) {

                    $functionalGroups = $this->getResponseParam('functionalGroups');

                    foreach ($functionalGroups as $item) {
                        EpFunctionalGroup::add($this->model->id, $item);
                    }

                    $this->model->status_parser = STATUS_PARSER_COMPLETE;

                } else {
                    $this->model->status_parser = STATUS_PARSER_ERROR;
                }
            } catch (\Exception $exception) {
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
        return [
            'brandId' => $this->model->type->brand->ep_id,
            'modelId' => $this->model->ep_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->model = EpProductModel::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}