<?php

namespace app\models\agconet\query;

/**
 * This is the ActiveQuery class for [[\app\models\agconet\service\ParserStep]].
 *
 * @see \app\models\agconet\service\ParserStep
 */
class ParserStepQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\ParserStep[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\service\ParserStep|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
