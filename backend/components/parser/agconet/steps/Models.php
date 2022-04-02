<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Model;
use app\models\agconet\service\ModelGroup;
use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class Models extends AgconetBaseStep
{
    private string $stepTitle = StepAgconetEnum::MODELS_STEP;
    protected ?ModelGroup $model;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('models');
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
                $models = $this->getResponseParam('books');
                foreach ($models as $item) {
                    $model = new Model();
                    $model->model_id = $this->model->id;
                    $model->name = $item['booktitle'];
                    $model->site_id = $item['siteId'];
                    $model->book_id = $item['bookId'];
                    $model->first_page_id = $item['firstPageId'];
                    $model->status = (int)$item['status'];
                    if (!$model->save()) {
                        print_r($model->errors);
                    }
                }

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
            'brandTitle' => myUrlEncode($this->model->partsBook->brand->name),
            'categoryId' => $this->model->key//'013261fc4d392f89be9b68f2ed0b27e2'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->model = $this->isChild ? $this->getParentInstance() : ModelGroup::findOne(['status_parser' => STATUS_PARSER_NEW]);

        if ($this->isParen && !empty($this->model)) {
            $this->setParentInstance($this->stepTitle, $this->model);
        }
    }
}