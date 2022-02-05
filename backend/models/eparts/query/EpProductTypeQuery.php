<?php

namespace app\models\eparts\query;

/**
 * This is the ActiveQuery class for [[\app\models\eparts\db\EpProductType]].
 *
 * @see \app\models\eparts\db\EpProductType
 */
class EpProductTypeQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\db\EpProductType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\db\EpProductType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
