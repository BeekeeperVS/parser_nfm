<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Brand;
use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class BrandItem extends AgconetBaseStep
{
    private string $stepTitle = StepAgconetEnum::BRAND_ITEM_STEP;
    protected ?Brand $model;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('brand-item');
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
                $subcategories= $this->getResponseParam('subcategories');

                $this->model->parts_books_key = $subcategories['каталоги запасных частей'] ?? null;
                $this->model->workshop_service_manuals_key = $subcategories['сервисные публикации'] ?? null;
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
            'brandTitle' => myUrlEncode($this->model->name)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->model = Brand::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}