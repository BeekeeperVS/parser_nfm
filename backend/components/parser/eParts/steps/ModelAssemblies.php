<?php

namespace components\parser\eParts\steps;

use app\models\eparts\EpAssembly;

class ModelAssemblies extends EPartsBaseStep
{

    public int $brandId;
    public int $modelId;

    public int $epBrandId;
    public string $epModelId;
    public string $epFunctionalGroupId;
    public bool $epIsTechnicalTypeDriven;
    private string $epImageType = 'large';
    private bool $epFilterForSN = false;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('model-assemblies');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $assemblies= $this->getResponseParam('assemblies');
        }

        foreach ($assemblies as $item) {
            $assembly = new EpAssembly();
            $assembly->model_functional_group_id = 1;
            $assembly->ep_id = $item['assemblyId'];
            $assembly->code = $item['assemblyCode'];
            $assembly->name = $item['assemblyName'];
            $assembly->has_note = $item['hasNote'] ?? false;
            $assembly->image = $item['image'];
            if(!$assembly->save()){
                var_dump($assembly->errors);
            }
        }
    }


    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->epBrandId,
            'modelId' => $this->epModelId,

            'functionalGroupId' => $this->epFunctionalGroupId,
            'isTechnicalTypeDriven' => $this->epIsTechnicalTypeDriven,
            'imageType' => $this->epImageType,
            'filterForSN' => $this->epFilterForSN
        ];
    }

}