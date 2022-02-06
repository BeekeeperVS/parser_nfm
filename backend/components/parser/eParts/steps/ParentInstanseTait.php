<?php

namespace components\parser\eParts\steps;

use yii\db\ActiveRecord;

trait ParentInstanseTait
{

    private static array $parentInstances = [];

    public bool $isParen = false;
    public bool $isChild = false;
    public string $parentStep;

    /**
     * @param string $stepParent
     * @param ActiveRecord $model
     * @return void
     */
    public function setParentInstance(string $stepParent, ActiveRecord $model)
    {
        self::$parentInstances[$stepParent] = $model;
    }

    /**
     * @param string $stepParent
     * @return ActiveRecord|null
     */
    public function getParentInstance(): ?ActiveRecord
    {
        if(isset(self::$parentInstances[$this->parentStep])) {
            return self::$parentInstances[$this->parentStep];
        }

        return null;
    }

}