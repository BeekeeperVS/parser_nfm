<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use app\models\eparts\service\EpPart;
use components\parser\eParts\enum\StepEpartsEnum;

class PartKits extends EPartsBaseStep
{
    private string $stepTitle = StepEpartsEnum::PART_KITS_STEP;

    protected ?EpPart $part;

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setApiMethod('part-kits');
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if (!empty($this->part)) {
            if (!$this->part->kit_indicator) return;
            $this->part->status_parser = STATUS_PARSER_ACTIVE;
            $this->part->save();

            try {
                parent::run();
                $isErrorParser = false;
            } catch (\Throwable $e) {
                $isErrorParser = true;
            }

            if (!$isErrorParser && $this->isSuccess()) {
                $partKits = $this->getResponseParam('partKits');
                if (!empty($partKits)) {
                    $this->part->kits = $partKits;
                    if (!$this->part->save()) {
                        // add logger;
                    }
                }

                $this->part->status_parser = STATUS_PARSER_COMPLETE;
            } else {
                $this->part->status_parser = STATUS_PARSER_ERROR;
            }
            $this->part->save();
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
            'brandId' => $this->part->assembly->modelFunctionalGroup->productModel->type->brand->ep_id,//epBrandId,
            'partId' => $this->part->ep_id,
            'modelId' => $this->part->assembly->modelFunctionalGroup->productModel->ep_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->part = $this->isChild ? $this->getParentInstance() : EpPart::findOne(['status_parser' => STATUS_PARSER_NEW]);

        if ($this->isParen) {
            $this->setParentInstance($this->stepTitle, $this->part);
        }
    }

}