<?php

namespace components\parser\eParts\steps;

use app\models\eparts\EpAssembly;

class AssemblyDetails extends EPartsBaseStep
{

    public int $brandId;
    public int $modelId;
    public int $assemblyId;

    public int $epBrandId;
    public string $epModelId;
    public string $epAssemblyId;
    public bool $epIsTechnicalTypeDriven;
    private ?string $epSerialNumberId = null;
    private string $epImageType = 'large';
    private bool $epFilterForSN = false;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('assembly-details');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        parent::run();

        if ($this->isSuccess()) {
            $assemblyDetails = $this->getResponseParam('assemblyDetails');
            $assemblyModel = EpAssembly::findOne($this->assemblyId);
            if (isset($assemblyModel) && isset($assemblyDetails['hotspots'])) {
                $assemblyModel->details = ['hotspots' => $assemblyDetails['hotspots']];
                if (!$assemblyModel->save()) {
                    print_r($assemblyModel->errors);
                }
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
            'assemblyId' => $this->epAssemblyId,
            'modelId' => $this->epModelId,
            'serialNumberId' => $this->epSerialNumberId,
            'imageType' => $this->epImageType,
            'isTechnicalTypeDriven' => $this->epIsTechnicalTypeDriven,
            'filterForSN' => $this->epFilterForSN
        ];
    }
}