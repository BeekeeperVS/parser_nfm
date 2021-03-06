<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Model;
use app\models\agconet\service\ParserStep;
use app\models\agconet\service\Scheme;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property Model $model
 */
class Schemes extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::SCHEMES_STEP,
            'dataModelClass' => Model::class,
            'apiMethod' => '/schemes'
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

                $schemes = $this->getResponseParam(null);
                if (is_array($schemes)) {
                    foreach ($schemes as $item) {
                        if ($item['level'] != 1) continue;
                        $this->saveSchemeData($item);
                    }
                    foreach ($schemes as $item) {
                        if ($item['level'] != 2) continue;
                        $this->saveSchemeData($item);
                    }
                    foreach ($schemes as $item) {
                        if ($item['level'] != 3) continue;
                        $this->saveSchemeData($item);
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
            'brandTitle' => $this->model->site_id,
            'modelId' => $this->model->book_id,
            'tocGuid' => $this->model->key
        ]);
    }

    private function saveSchemeData(array $item)
    {
        $model = new Scheme();
        $model->model_id = $this->model->id;
        $model->name = $item['pagetitle'];
        $model->key = $item['guid'];
        $model->parent_key = $item['parent'] ?? null;
        $model->level = (int)$item['level'];
        $model->has_child = (int)$item['hasChilds'];
        $model->site_id = $item['id'];
        $model->page_info = $item['pageInfo'];
        $model->display = $item['display'];
        $model->display_short = $item['displayShort'];
        $model->page_number = (int)$item['pageNumber'];
        $model->status_parser = ($model->level != 3) ? 200 : 0;
        if (!$model->save()) {
            print_r($model->errors);
        }
    }
}