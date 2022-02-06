<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpAssembly;
use components\parser\eParts\enum\StepEpartsEnum;

class AssemblyDetails extends EPartsBaseStep
{
    private string $stepTitle = StepEpartsEnum::ASSEMBLY_DETAILS_STEP;

    protected ?EpAssembly $assembly;

    public int $brandId;
    public int $modelId;
    public int $assemblyId;

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
        if (!empty($this->assembly)) {
            $this->assembly->status_parser = STATUS_PARSER_ACTIVE;
            $this->assembly->save();

            try {
                parent::run();
                $isErrorParser = false;
            } catch (\Throwable $e) {
                $isErrorParser = true;
            }

            if (!$isErrorParser && $this->isSuccess()) {
                $assemblyDetails = $this->getResponseParam('assemblyDetails');
                if (isset($assemblyDetails['hotspots'])) {
                    $this->assembly->details = ['hotspots' => $assemblyDetails['hotspots']];
                    if (!$this->assembly->save()) {
                        // add logger;
                    }
                }

                $this->assembly->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->assembly->status_parser = STATUS_PARSER_ERROR;
            }
        } else {
            ParserStep::complete($this->parserName, $this->action, $this->stepTitle);
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return [
            'brandId' => $this->assembly->modelFunctionalGroup->productModel->type->brand->ep_id,//epBrandId,
            'assemblyId' => $this->assembly->ep_id,//epAssemblyId,
            'modelId' => $this->assembly->modelFunctionalGroup->productModel->ep_id,//epModelId,
            'serialNumberId' => $this->assembly->modelFunctionalGroup->productModel->series->ep_id,//epSerialNumberId,
            'isTechnicalTypeDriven' => $this->assembly->modelFunctionalGroup->productModel->is_technical_type_driven,//epIsTechnicalTypeDriven,
            'imageType' => $this->epImageType,
            'filterForSN' => $this->epFilterForSN
        ];
    }


    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->assembly = $this->isChild ? $this->getParentInstance() : \app\models\eparts\service\EpAssembly::findOne(['status_parser' => STATUS_PARSER_NEW]);

        if ($this->isParen) {
            $this->setParentInstance($this->stepTitle, $this->assembly);
        }
    }
}