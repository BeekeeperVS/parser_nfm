<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use components\parser\eParts\enum\StepEpartsEnum;
use yii\helpers\Json;

class Brands extends EPartsBaseStep
{
    /** @var string $userId */
    public $userId;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('brands');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {

        parent::run();

        if ($this->isSuccess()) {
            $brands = $this->getResponseParam('brands');

            $batch_params = [];
            foreach ($brands as $item) {
                $batch_params[] = [$item['brandId'], $item['brandName'], $item['brandCode']];
            }

            \Yii::$app->db->createCommand()->batchInsert('{{%ep_brand}}', ['ep_id', 'name', 'code'], $batch_params)->execute();

            ParserStep::complete($this->parserName, $this->action, StepEpartsEnum::BRANDS_STEP);
        } else {
            ParserStep::complete($this->parserName, $this->action, StepEpartsEnum::BRANDS_STEP);
        }


    }

}