<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpAssembly;
use app\models\eparts\EpPart;
use components\parser\eParts\enum\StepEpartsEnum;

class AssemblyParts extends EPartsBaseStep
{
    private string $stepTitle = StepEpartsEnum::ASSEMBLY_PARTS_STEP;

    protected ?EpAssembly $assembly;

    public int $brandId;
    public int $modelId;
    public int $assemblyId;
    public int $functionalGroupId;

    public int $epBrandId;
    public string $epModelId;
    public string $epAssemblyId;
    public bool $epIsTechnicalTypeDriven;
    public string $epFunctionalGroupId;
    private ?string $epSerialNumberId = 'undefined';
    private string $epImageType = 'large';
    private bool $epFilterForSN = false;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('assembly-parts');
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
                $assemblyParts = $this->getResponseParam('assemblyParts');
                foreach ($assemblyParts as $part) {
                    $partModel = new EpPart();
                    $partModel->ep_id = $part['partId'];
                    $partModel->assembly_id = $this->assembly->id;
                    $partModel->sku_global = $part['skuGlobal'];
                    $partModel->technical_description = $part['technicalDescription'];
                    $partModel->reman_indicator = $part['remanIndicator'];
                    $partModel->description = $part['partDescription'];
                    $partModel->notes = $part['notes'];
                    $partModel->is_in_working_list = $part['isInWorkingList'];
                    $partModel->alternative_indicator = $part['alternativeIndicator'];
                    $partModel->substitution_indicator = $part['substitutionIndicator'];
                    $partModel->kit_indicator = $part['kitIndicator'];
                    $partModel->substitution_code = $part['substitutionCode'];
                    $partModel->substitution_type = $part['substitutionType'];
                    $partModel->component_indicator = $part['componentIndicator'];
                    $partModel->ep_assembly_part_list_id = $part['assemblyPartListId'];
                    $partModel->reference_number = $part['referenceNumber'];
                    $partModel->quantity = $part['quantity'];
                    $partModel->number = $part['partNumber'];
                    $partModel->ep_assembly_id = $part['assemblyId'];
                    $partModel->image = isset($part['image']) ? (string)$part['image'] : '';
                    $partModel->sequence_number = isset($part['sequence_number']) ? (string)$part['sequence_number'] : '';
                    $partModel->usage = $part['usage'];
                    $partModel->technical_image = isset($part['technicalImage']) ? (string)$part['technicalImage'] : '';
                    if (!$partModel->save()) {
                        // add logger;
                    }

                }

                $this->assembly->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->assembly->status_parser = STATUS_PARSER_ERROR;
            }
            $this->assembly->save();
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
            'functionalGroupId' => $this->assembly->modelFunctionalGroup->functionalGroup->ep_id,//epFunctionalGroupId,
            'imageType' => $this->epImageType,
            'filterForSN' => $this->epFilterForSN
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->assembly = $this->isChild ? $this->getParentInstance() : EpAssembly::findOne(['status_parser' => STATUS_PARSER_NEW]);

        if ($this->isParen) {
            $this->setParentInstance($this->stepTitle, $this->assembly);
        }
    }

}