<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class Brands extends AgconetBaseStep
{
    private string $stepTitle = StepAgconetEnum::BRANDS_STEP;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('brands');
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $brands = $this->getResponseParam('null');

            $batch_params = [];
            foreach ($brands as $item) {
                $batch_params[] = [$item];
            }

            \Yii::$app->db3->createCommand()->batchInsert('{{%brand}}', ['name'], $batch_params)->execute();

            ParserStep::complete($this->parserName, $this->action, $this->stepTitle);
        } else {
            ParserStep::complete($this->parserName, $this->action, $this->stepTitle);
        }
    }


//    /**
//     * @return array
//     */
//    public function makeDataRequest(): array
//    {
//        return array_merge(parent::makeDataRequest(), []);
//    }
}