<?php

namespace app\models\common\query;

use app\models\common\service\ParserStep;

/**
 * This is the ActiveQuery class for [[\app\models\common\service\ParserStep]].
 *
 * @see \app\models\common\service\ParserStep
 */
class ParserStepQuery extends \app\service\db\ActiveQueryService
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\common\service\ParserStep[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\common\service\ParserStep|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return ParserStep
     */
    public function currentStep(): ParserStep
    {
        return $this->where(['and',
            ['not in', 'status', [STATUS_PARSER_COMPLETE, STATUS_PARSER_ERROR]],
            ['parent_step' => null]
        ])->orderBy(['sort_order' => SORT_ASC])->one();
    }
}
