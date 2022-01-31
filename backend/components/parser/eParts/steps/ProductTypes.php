<?php

namespace components\parser\eParts\steps;

use yii\helpers\Json;

class ProductTypes extends EPartsBaseStep
{

    public int $brandId;
    public int $epBrandId;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('product-types');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $productTypes = $this->getResponseParam('productTypes');
        }
        $batchParams = [];
        foreach ($productTypes as $item) {

            $batchParams[] = [$this->brandId, $item['productTypeId'], $item['productTypeDescription']];
        }
        \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_type}}', ['brand_id', 'ep_id', 'description'], $batchParams)->execute();

    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId
        ];
    }
}