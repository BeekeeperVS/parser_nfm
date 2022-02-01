<?php

namespace components\parser\eParts\steps;

use app\models\eparts\EpAssembly;
use app\models\eparts\EpPart;

class AssemblyParts extends EPartsBaseStep
{

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
        parent::run();

        if ($this->isSuccess()) {
            $assemblyParts = $this->getResponseParam('assemblyParts');
            foreach ($assemblyParts as $part) {
                $partModel = new EpPart();
                $partModel->ep_id = $part['partId'];
                $partModel->assembly_id = $this->assemblyId;
                $partModel->sku_global = $part['skuGlobal'];
                $partModel->technical_description = $part['technicalDescription'];
                $partModel->reman_indicator = $part['remanIndicator'];
                $partModel->description = $part['partDescription'];
                $partModel->notes = $part['notes'];
                $partModel->is_in_working_list = $part['isInWorkingList'];
                $partModel->alternative_indicator = $part['alternativeIndicator'];
                $partModel->substitution_indicator = $part['substitutionIndicator'];
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
                    print_r($partModel->errors);
                    die;
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
            'filterForSN' => $this->epFilterForSN,
            'functionalGroupId' => $this->epFunctionalGroupId
        ];
    }


//brandId: number;
//assemblyId: string;//B2C020B1-B8BF-E111-9FCE-005056875BD6
//modelId: string;//22F9724F-E6BE-E111-9FCE-005056875BD6
//serialNumberId?: string;//undefined
//imageType: string;//large
//isTechnicalTypeDriven: boolean;//false
//filterForSN: boolean;//false
//functionalGroupId: string;//22F9724F-E6BE-E111-9FCE-005056875BD6_01_ENGINE
}