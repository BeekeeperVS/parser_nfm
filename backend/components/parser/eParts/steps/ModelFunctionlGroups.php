<?php

namespace components\parser\eParts\steps;

class ModelFunctionlGroups extends EPartsBaseStep
{
    public int $brandId;
    public int $modelId;

    public int $epBrandId;
    public string $epModelId;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('model-functional-groups');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $functionalGroups= $this->getResponseParam('functionalGroups');
        }
        $batchParams = [];
        foreach ($functionalGroups as $item) {
            $batchParams[] = [$item['functionalGroupId'], $item['functionalGroupCode'], $item['functionalGroupDescription']];
        }
        \Yii::$app->db->createCommand()->batchInsert('{{%ep_functional_group}}', [ 'ep_id', 'code','description'], $batchParams)->execute();
    }


    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId,
            'modelId' => $this->epModelId
        ];
    }

}