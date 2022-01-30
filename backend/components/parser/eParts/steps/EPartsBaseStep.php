<?php

namespace components\parser\eParts\steps;

use yii\base\BaseObject;

abstract class EPartsBaseStep extends BaseObject implements EPartsStepInterface
{
    private $response;

    /**
     * {@inheritDoc}
     */
    public function isSuccess(): bool
    {
        return true;
    }
}