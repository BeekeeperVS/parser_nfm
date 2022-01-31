<?php

namespace components\parser\eParts\steps;

use JetBrains\PhpStorm\ArrayShape;

class ProductSeries extends EPartsBaseStep
{
    public int $brandId;
    public int $typeId;
    public int $lineId;

    public int $epBrandId;
    public string $epTypeId;
    public string $epLineId;

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
        parent::run();

        if($this->isSuccess()) {
            $productSeries = $this->getResponseParam('productSeries');
        }
        $batch_params = [];
        foreach ($productSeries as $item) {
            $batch_params[] = [$this->typeId, $this->lineId, $item['seriesId'], $item['seriesDescription']];
        }
        \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_series}}', ['type_id','line_id','ep_id', 'description'], $batch_params)->execute();
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId,
            'productTypeId' => $this->epTypeId,
            'productLineId' => $this->epLineId
        ];
    }
}