<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpProductLine;
use components\parser\eParts\enum\StepEpartsEnum;
use JetBrains\PhpStorm\ArrayShape;

class ProductSeries extends EPartsBaseStep
{
    protected ?EpProductLine $line;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('product-series');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if (!empty($this->line)) {

            $this->line->status_parser = STATUS_PARSER_ACTIVE;
            $this->line->save();

            parent::run();

            if ($this->isSuccess()) {
                $productSeries = $this->getResponseParam('productSeries');
                $batch_params = [];
                foreach ($productSeries as $item) {
                    $batch_params[] = [$this->line->type->id, $this->line->id, $item['seriesId'], $item['seriesDescription']];
                }
                \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_series}}', ['type_id', 'line_id', 'ep_id', 'description'], $batch_params)->execute();

                $this->line->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->line->status_parser = STATUS_PARSER_ERROR;
            }
            $this->line->save();

        } else {
            ParserStep::complete($this->parserName, $this->action, StepEpartsEnum::PRODUCT_TYPES_STEP);
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->line->type->brand->ep_id,
            'productTypeId' => $this->line->type->ep_id,
            'productLineId' => $this->line->ep_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->line = EpProductLine::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}