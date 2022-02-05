<?php

namespace app\models\eparts\service;

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
class EpBrand extends \app\models\eparts\db\EpBrand
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
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpProductTypeQuery
     */
    public function getEpProductTypes()
    {
        return $this->hasMany(EpProductType::className(), ['brand_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\query\EpBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\eparts\query\EpBrandQuery(get_called_class());
    }
}
