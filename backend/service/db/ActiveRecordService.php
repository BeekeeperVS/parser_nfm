<?php


namespace app\service\db;


use app\service\behavior\TimestampBehavior;
use Yii;

class ActiveRecordService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge( parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'create' => ['created_at', 'updated_at'],
                'update' => ['updated_at'],
            ]
        ]);
    }

}