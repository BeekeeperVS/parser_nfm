<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Model;
use app\models\agconet\service\ParserStep;
use app\models\catalog\NcModel;
use app\models\catalog\NcSeries;
use components\parser\agconet\enum\StepAgconetEnum;


/**
 * @property Model $model
 */
class ModelSchemes extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::MODEL_SCHEMES_STEP,
            'dataModelClass' => Model::class,
            'apiMethod' => '/model-schemes'
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

                $modelSchemeKey = $this->getResponseParam(null)[0];
                $this->model->key = $modelSchemeKey;
                if (!$this->model->save()) {
                    print_r($this->model->errors);
                }

                $this->saveNcCatalog();

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
            'brandTitle' => $this->model->site_id,//'generalpublications',
            'modelId' => $this->model->book_id//4820992110
        ]);
    }

    /**
     * @return void
     */
    private function saveNcCatalog()
    {
        $ncSeries = NcSeries::findOne(['external_id' => $this->model->model->key]);

        if (empty($ncSeries)) return;

        $ncModel = new NcModel();
        $ncModel->external_id = $this->model->key;
        $ncModel->series_id = $ncSeries->id;
        $ncModel->name = $this->model->name;
        if (!$ncModel->save()) {
            print_r($ncModel->errors);
        }

    }
}