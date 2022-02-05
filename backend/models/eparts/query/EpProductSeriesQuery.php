<?php

namespace app\models\eparts\query;

/**
 * This is the ActiveQuery class for [[\app\models\eparts\db\EpProductSeries]].
 *
 * @see \app\models\eparts\db\EpProductSeries
 */
class EpProductSeriesQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\db\EpProductSeries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\db\EpProductSeries|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
