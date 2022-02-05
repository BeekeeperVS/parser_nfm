<?php

namespace app\models\eparts\db;

use Yii;

/**
 * This is the model class for table "ep_functional_group".
 *
 * @property int $id
 * @property string $ep_id
 * @property string $code
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpModelFunctionalGroup[] $epModelFunctionalGroups
 */
class EpFunctionalGroup extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_functional_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ep_id', 'code', 'description'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['ep_id', 'code', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ep_id' => 'Ep ID',
            'code' => 'Code',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpModelFunctionalGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpModelFunctionalGroups()
    {
        return $this->hasMany(EpModelFunctionalGroup::className(), ['functional_group_id' => 'id']);
    }
}
