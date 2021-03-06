<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\Brand;
use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property Brand $model
 */
class BrandItem extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::BRAND_ITEM_STEP,
            'dataModelClass' => Brand::class,
            'apiMethod' => '/brand-item'
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
                $subcategories = $this->getResponseParam('subcategories');

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

}