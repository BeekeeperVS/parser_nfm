<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Brand;
use app\models\agconet\service\ParserStep;
use app\models\agconet\service\PartsBook;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property Brand $model
 */
class CatalogPats extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::CATALOG_PATS_STEP,
            'dataModelClass' => Brand::class,
            'apiMethod' => '/catalog-pats'
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
                $partsBooks = $this->getResponseParam('subcategories');
                foreach ($partsBooks as $name => $key) {
                    if ($name === '$id') {
                        continue;
                    }
                    $partsBook = new PartsBook();
                    $partsBook->brand_id = $this->model->id;
                    $partsBook->name = $name;
                    $partsBook->key = $key;
                    if (!$partsBook->save()) {
                        print_r($partsBook->errors);
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
            'brandTitle' => myUrlEncode($this->model->name),
            'categoryId' => $this->model->parts_books_key//'0dc58f37d9ce82cf7dd9d993adbdfe58'
        ]);
    }

//    /**
//     * @inheritDoc
//     */
//    public function init()
//    {
//        $this->model = $this->isChild ? $this->getParentInstance() : Brand::findOne(['status_parser' => STATUS_PARSER_NEW]);
//
//        if ($this->isParen) {
//            $this->setParentInstance($this->stepTitle, $this->model);
//        }
//    }
}