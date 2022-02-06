<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\EpAssembly;
use app\models\eparts\service\EpModelFunctionalGroup;
use components\parser\eParts\enum\StepEpartsEnum;

class ModelAssemblies extends EPartsBaseStep
{
    private string $stepTitle = StepEpartsEnum::MODEL_ASSEMBLIES_STEP;
    protected ?EpModelFunctionalGroup $modelFunctionalGroup;

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
        if (!empty($this->modelFunctionalGroup)) {

            $this->modelFunctionalGroup->status_parser = STATUS_PARSER_ACTIVE;
            $this->modelFunctionalGroup->save();

            try {
                parent::run();
                $isErrorParser = false;
            } catch (\Throwable $e) {
                $isErrorParser = true;
            }

            if (!$isErrorParser && $this->isSuccess()) {
                $assemblies = $this->getResponseParam('assemblies');
                foreach ($assemblies as $item) {
                    $assembly = new EpAssembly();
                    $assembly->model_functional_group_id = $this->modelFunctionalGroup->functional_group_id;
                    $assembly->ep_id = $item['assemblyId'];
                    $assembly->code = $item['assemblyCode'];
                    $assembly->name = $item['assemblyName'];
                    $assembly->has_note = $item['hasNote'] ?? false;
                    $assembly->image = $item['image'];
                    $assembly->save();
                }

                $this->modelFunctionalGroup->status_parser = STATUS_PARSER_COMPLETE;

            } else {
                $this->modelFunctionalGroup->status_parser = STATUS_PARSER_ERROR;
            }
            $this->modelFunctionalGroup->save();
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
            'functionalGroupId' => $this->modelFunctionalGroup->functionalGroup->ep_id,//epFunctionalGroupId,
            'brandId' => $this->modelFunctionalGroup->productModel->type->brand->ep_id,//epBrandId,
            'modelId' => $this->modelFunctionalGroup->productModel->ep_id,//epModelId,
            'isTechnicalTypeDriven' => $this->modelFunctionalGroup->productModel->is_technical_type_driven,//pIsTechnicalTypeDriven,
            'imageType' => $this->epImageType,
            'filterForSN' => $this->epFilterForSN
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->modelFunctionalGroup = EpModelFunctionalGroup::findOne(['status_parser' => STATUS_PARSER_NEW]);
    }
}