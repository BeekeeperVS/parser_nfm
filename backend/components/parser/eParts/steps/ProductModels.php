<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpProductSeries;
use components\parser\eParts\enum\StepEpartsEnum;

class ProductModels extends EPartsBaseStep
{
    protected ?EpProductSeries $series;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('product-models');
    }


    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if (!empty($this->series)) {

            $this->series->status_parser = STATUS_PARSER_ACTIVE;
            $this->series->save();

            parent::run();

            if ($this->isSuccess()) {
                $productModels = $this->getResponseParam('productModels');
                $batch_params = [];
                foreach ($productModels as $item) {
                    $batch_params[] = [
                        $this->series->type_id,
                        $this->series->line_id,
                        $this->series->id,
                        $item['modelId'],
                        $item['modelDescription'],
                        $item['modelNumber'],
                        $item['prodEndDate'],
                        $item['prodStartDate'],
                        $item['isTechnicalTypeDriven'] ?? false
                    ];
                }
                \Yii::$app->db->createCommand()->batchInsert(
                    '{{%ep_product_model}}',
                    ['type_id', 'line_id', 'series_id', 'ep_id', 'description', 'model_number', 'prod_end_date', 'prod_start_date', 'is_technical_type_driven'],
                    $batch_params
                )->execute();

                $this->series->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->series->status_parser = STATUS_PARSER_ERROR;
            }
            $this->series->save();


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
            'brandId' => $this->series->type->brand->ep_id,
            'productTypeId' => $this->series->type->ep_id,
            'productLineId' => $this->series->line->ep_id,
            'seriesId' => $this->series->ep_id

        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->series = EpProductSeries::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}