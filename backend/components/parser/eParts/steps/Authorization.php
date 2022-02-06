<?php

namespace components\parser\eParts\steps;

use app\models\common\service\ParserStep;
use components\parser\eParts\enum\StepEpartsEnum;

class Authorization extends EPartsBaseStep
{
    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        ParserStep::complete($this->parserName, $this->action, StepEpartsEnum::LOGIN_STEP);
    }
}