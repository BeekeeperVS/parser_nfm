<?php

namespace components\parser\eParts\steps;

use app\models\eparts\service\EpBrand;
use app\models\common\service\ParserStep;
use components\parser\eParts\enum\StepEpartsEnum;
use yii\helpers\Json;

class ProductTypes extends EPartsBaseStep
{
    private ?EpBrand $brand;

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
        if (!empty($this->brand)) {

            $this->brand->status_parser = STATUS_PARSER_ACTIVE;
            $this->brand->save();

            parent::run();

            if ($this->isSuccess()) {
                $productTypes = $this->getResponseParam('productTypes');
                $batchParams = [];
                foreach ($productTypes as $item) {
                    $batchParams[] = [$this->brand->id, $item['productTypeId'], $item['productTypeDescription']];
                }
                \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_type}}', ['brand_id', 'ep_id', 'description'], $batchParams)->execute();
                $this->brand->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->brand->status_parser = STATUS_PARSER_ERROR;
            }

            $this->brand->save();
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
            'brandId' => $this->brand->ep_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->brand = EpBrand::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}