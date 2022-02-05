<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\EpProductType;
use components\parser\eParts\enum\StepEpartsEnum;

class ProductLines extends EPartsBaseStep
{
    public const API_METHOD = '/product-lines';

    public ?EpProductType $type;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('product-lines');
    }
    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if (!empty($this->type)) {

            $this->type->status_parser = STATUS_PARSER_ACTIVE;
            $this->type->save();

            parent::run();

            if ($this->isSuccess()) {
                $productLines = $this->getResponseParam('productLines');

                $batch_params = [];
                foreach ($productLines as $item) {
                    $batch_params[] = [$this->type->id, $item['productLineId'], $item['productLineDescription']];
                }
                \Yii::$app->db->createCommand()->batchInsert('{{%ep_product_line}}', ['type_id', 'ep_id', 'description'], $batch_params)->execute();

                $this->type->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->type->status_parser = STATUS_PARSER_ERROR;
            }
            $this->type->save();
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
            'brandId' => $this->type->brand->ep_id,
            'productTypeId' => $this->type->ep_id,
        ];
    }


    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->type = EpProductType::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}