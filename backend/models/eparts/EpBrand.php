<?php

namespace app\models\eparts;

use Yii;

/**
 * This is the model class for table "ep_brand".
 *
 * @property int $id
 * @property int $ep_id
 * @property string $name
 * @property string $code
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpProductType[] $epProductTypes
 */
class EpBrand extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ep_id', 'name', 'code'], 'required'],
            [['ep_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'code' => 'Code',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpProductTypes()
    {
        return $this->hasMany(EpProductType::className(), ['brand_id' => 'id']);
    }
}
