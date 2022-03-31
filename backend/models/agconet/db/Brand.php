<?php

namespace app\models\agconet\db;

use Yii;

/**
 * This is the model class for table "agc_brand".
 *
 * @property int $id
 * @property string $name
 * @property string|null $parts_books_key
 * @property string|null $workshop_service_manuals_key
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PartsBook[] $partsBooks
 */
class Brand extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_brand';
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
            [['name'], 'required'],
            [['status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'parts_books_key', 'workshop_service_manuals_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parts_books_key' => 'Parts Books Key',
            'workshop_service_manuals_key' => 'Workshop Service Manuals Key',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[PartsBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartsBooks()
    {
        return $this->hasMany(PartsBook::className(), ['brand_id' => 'id']);
    }
}
