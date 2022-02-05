<?php

namespace app\models\eparts\service;

use Yii;

/**
 * This is the model class for table "ep_product_type".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $ep_id
 * @property string $description
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpBrand $brand
 * @property EpProductLine[] $epProductLines
 * @property EpProductModel[] $epProductModels
 * @property EpProductSeries[] $epProductSeries
 */
class EpProductType extends \app\models\eparts\db\EpProductType
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_product_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'ep_id', 'description'], 'required'],
            [['brand_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ep_id', 'description'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpBrand::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'ep_id' => 'Ep ID',
            'description' => 'Description',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpBrandQuery
     */
    public function getBrand()
    {
        return $this->hasOne(EpBrand::className(), ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[EpProductLines]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpProductLineQuery
     */
    public function getEpProductLines()
    {
        return $this->hasMany(EpProductLine::className(), ['type_id' => 'id']);
    }

    /**
     * Gets query for [[EpProductModels]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpProductModelQuery
     */
    public function getEpProductModels()
    {
        return $this->hasMany(EpProductModel::className(), ['type_id' => 'id']);
    }

    /**
     * Gets query for [[EpProductSeries]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpProductSeriesQuery
     */
    public function getEpProductSeries()
    {
        return $this->hasMany(EpProductSeries::className(), ['type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\query\EpProductTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\eparts\query\EpProductTypeQuery(get_called_class());
    }
}
