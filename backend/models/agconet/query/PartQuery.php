<?php

namespace app\models\agconet\query;

/**
 * This is the ActiveQuery class for [[\app\models\agconet\service\Part]].
 *
 * @see \app\models\agconet\service\Part
 */
class PartQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\Part[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\Part|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
