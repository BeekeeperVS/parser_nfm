<?php

namespace components\parser\eParts\steps;

use yii\helpers\Json;

class ProductLines extends EPartsBaseStep
{
    public const API_METHOD = '/product-lines';

    public int $brandId;
    public int $typeId;

    public int $epBrandId;
    public string $epTypeId;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $productLines= $this->getResponseParam('productLines');

            $batch_params = [];
            foreach ($productLines as $item) {
                $batch_params[] = [$this->typeId, $item['productLineId'], $item['productLineDescription']];
            }
            \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_line}}', ['type_id', 'ep_id', 'description'], $batch_params)->execute();
        }

    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId,
            'productTypeId' => $this->epTypeId,

        ];
    }
}