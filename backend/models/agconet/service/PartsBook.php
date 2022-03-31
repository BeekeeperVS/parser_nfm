<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_parts_book".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property string $key
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Brand $brand
 * @property ModelGroup[] $modelGroups
 */
class PartsBook extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_parts_book';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'name', 'key'], 'required'],
            [['brand_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'key'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'name' => 'Name',
            'key' => 'Key',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery|\app\models\agconet\query\BrandQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[ModelGroups]].
     *
     * @return \yii\db\ActiveQuery|\app\models\agconet\query\ModelGroupQuery
     */
    public function getModelGroups()
    {
        return $this->hasMany(ModelGroup::className(), ['parts_book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\PartsBookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\PartsBookQuery(get_called_class());
    }
}
