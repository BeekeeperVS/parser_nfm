<?php

namespace components\parser\eParts\steps;

class ProductModels extends EPartsBaseStep
{
    public int $brandId;
    public int $typeId;
    public int $lineId;
    public int $seriesId;

    public int $epBrandId;
    public string $epTypeId;
    public string $epLineId;
    public string $epSeriesId;


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
        parent::run();

        if ($this->isSuccess()) {
            $productModels = $this->getResponseParam('productModels');
        }
        $batch_params = [];
        foreach ($productModels as $item) {
            $batch_params[] = [
                $this->typeId,
                $this->lineId,
                $this->seriesId,
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
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId,
            'productTypeId' => $this->epTypeId,
            'productLineId' => $this->epLineId,
            'seriesId' => $this->epSeriesId

        ];
    }
}