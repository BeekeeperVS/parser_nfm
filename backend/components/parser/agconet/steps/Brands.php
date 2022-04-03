<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use components\parser\agconet\enum\StepAgconetEnum;

class Brands extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::BRANDS_STEP,
            'apiMethod' => '/brands'
        ]));
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $brands = $this->getResponseParam(null);

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

}