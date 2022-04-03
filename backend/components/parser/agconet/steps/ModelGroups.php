<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ModelGroup;
use app\models\agconet\service\ParserStep;
use app\models\agconet\service\PartsBook;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property PartsBook $model
 */
class ModelGroups extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::MODEL_GROUPS_STEP,
            'dataModelClass' => PartsBook::class,
            'apiMethod' => '/model-groups'
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

                $modelGroups = $this->getResponseParam('subcategories');
                foreach ($modelGroups as $name => $key) {
                    if ($name === '$id') {
                        continue;
                    }
                    $modelGroup = new ModelGroup();
                    $modelGroup->parts_book_id = $this->model->id;
                    $modelGroup->name = $name;
                    $modelGroup->key = $key;
                    if (!$modelGroup->save()) {
                        print_r($modelGroup->errors);
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
            'brandTitle' => myUrlEncode($this->model->brand->name),
            'categoryId' => $this->model->key//'1dd2b039c0b9233051cde35dd6bde392'
        ]);
    }
//
//    /**
//     * @inheritDoc
//     */
//    public function init()
//    {
//        $this->model = $this->isChild ? $this->getParentInstance() : PartsBook::findOne(['status_parser' => STATUS_PARSER_NEW]);
//
//        if ($this->isParen && !empty($this->model)) {
//            $this->setParentInstance($this->stepTitle, $this->model);
//        }
//    }
}