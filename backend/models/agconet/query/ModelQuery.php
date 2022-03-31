<?php

namespace app\models\agconet\query;

/**
 * This is the ActiveQuery class for [[\app\models\agconet\service\Model]].
 *
 * @see \app\models\agconet\service\Model
 */
class ModelQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\Model[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\Model|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
