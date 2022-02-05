<?php

namespace app\models\eparts\service;

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
class EpFunctionalGroup extends \app\models\eparts\db\EpFunctionalGroup
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_functional_group';
    }

    /**
     * @param int $modelId
     * @param array $functionalGroup
     * @return void
     */
    public static function add(int $modelId, array $functionalGroup)
    {
        if (isset($functionalGroup['functionalGroupId']) && isset($functionalGroup['functionalGroupCode']) && isset($functionalGroup['functionalGroupDescription'])) {
            $functionalGroupModel = self::findOne(['ep_id' => $functionalGroup['functionalGroupId']]) ?: new self();

            if (empty($functionalGroupModel->id)) {
                $functionalGroupModel->ep_id = $functionalGroup['functionalGroupId'];
                $functionalGroupModel->code = $functionalGroup['functionalGroupCode'];
                $functionalGroupModel->description = $functionalGroup['functionalGroupDescription'];
                $functionalGroupModel->save();
            }

            if ($functionalGroupModel->id) {
                EpModelFunctionalGroup::add($modelId, $functionalGroupModel->id);
            }
        }

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
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpModelFunctionalGroupQuery
     */
    public function getEpModelFunctionalGroups()
    {
        return $this->hasMany(EpModelFunctionalGroup::className(), ['functional_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\query\EpFunctionalGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\eparts\query\EpFunctionalGroupQuery(get_called_class());
    }
}
