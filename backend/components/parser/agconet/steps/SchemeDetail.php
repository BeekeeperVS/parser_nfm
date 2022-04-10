<?php

namespace components\parser\agconet\steps;

use app\models\agconet\service\ParserStep;
use app\models\agconet\service\Part;
use app\models\agconet\service\Scheme;
use app\models\catalog\NcModel;
use app\models\catalog\NcPart;
use app\models\catalog\NcScheme;
use app\models\catalog\NcSchemePart;
use components\parser\agconet\enum\StepAgconetEnum;

/**
 * @property Scheme $model
 */
class SchemeDetail extends AgconetBaseStep
{

    /**
     * @param $config
     */
    public function __construct($config = [])
    {
        parent::__construct(array_merge($config, [
            'stepTitle' => StepAgconetEnum::SCHEME_DETAIL_STEP,
            'dataModelClass' => Scheme::class,
            'apiMethod' => '/scheme-detail'
        ]));
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if (!empty($this->model)) {

            $this->model->status_parser = STATUS_PARSER_ACTIVE;
            $this->model->save();

            try {
                parent::run();
                $isErrorParser = false;
            } catch (\Throwable $e) {
                $isErrorParser = true;
            }

            if (!$isErrorParser && $this->isSuccess()) {
                $page = $this->getResponseParam('page');
                $this->model->image_url = $this->getResponseParam('imageUrl');
                $this->model->image_data = $page['img'];
                if (!$this->model->save()) {
                    print_r($this->model->errors);
                }

                $entries = $page['entries'];

                if (is_array($entries)) {
                    foreach ($entries as $item) {
                        $part = new Part();
                        $part->scheme_id = $this->model->id;//$item[''];
                        $part->name = $item['partdescription'];
                        $part->article = $item['partnumber'];
                        $part->key = $item['guid'];
                        $part->quantity = (int)$item['partqty'] ?? null;
                        $part->item_id = (int)$item['itemid'] ?? null;
                        $part->specification = $item['TechSpec'] ?? null;
                        $part->detail_parser = $item;
                        if (!$part->save()) {
                            print_r($part->errors);
                        }

                        $this->saveNcCatalog($part);
                    }
                }
                $this->model->status_parser = STATUS_PARSER_COMPLETE;

            } else {
                $this->model->status_parser = STATUS_PARSER_ERROR;
            }
            $this->model->save();
        } else {
            ParserStep::complete($this->parserName, $this->action, $this->stepTitle);
        }
    }

    /**
     * @return array
     */
    public function makeDataRequest(): array
    {
        return array_merge(parent::makeDataRequest(), [
            'brandTitle' => $this->model->model->site_id,//'generalpublications',
            'modelId' => $this->model->model->book_id,//4820992110,
            'schemeId' => $this->model->site_id,
            'tocGuid' => $this->model->key//'bf03b76a-fd7a-774f-354d-f9db0ba593a0'
        ]);
    }


    /**
     * @param Part $part
     * @return void
     */
    private function saveNcCatalog(Part $agcPart)
    {
        $ncModel = NcModel::findOne(['external_id' => $this->model->model->key]);
        $ncScheme = NcScheme::findOne(['external_id' => $this->model->key]);

        if (empty($ncModel)) return;
        if (empty($ncScheme)) {
            $ncScheme = new NcScheme();
            $ncScheme->external_id = $this->model->key;
            $ncScheme->model_id = $ncModel->id;
            $ncScheme->name = $this->model->name;
            $ncScheme->assembly_image = $this->model->image_url;
            $ncScheme->save();
        }


        $ncPart = new NcPart();
        $ncPart->number = $agcPart->article ?: '-';
        $ncPart->name = $agcPart->name ?? $agcPart->specification ?? '-';
        $ncPart->description = $agcPart->specification ?: '-';
        $ncPart->usage = '-';
        $ncPart->weight = 0;

        if (!empty($ncPart->name) && $ncPart->name != '-' && $ncPart->save()) {
            $ncSchemePart = new NcSchemePart();
            $ncSchemePart->scheme_id = $ncScheme->id;
            $ncSchemePart->part_id = $ncPart->id;
            $ncSchemePart->position = (string)$agcPart->item_id;
            $ncSchemePart->quantity = $agcPart->quantity;
            $ncSchemePart->save();
            print_r($ncSchemePart->errors);
        } else {
            print_r($ncPart->errors);
        }

    }
}