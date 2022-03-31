<?php

namespace app\models\agconet\db;

use Yii;

/**
 * This is the model class for table "agc_model_group".
 *
 * @property int $id
 * @property int $parts_book_id
 * @property string $name
 * @property string $key
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Model[] $models
 * @property PartsBook $partsBook
 */
class ModelGroup extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_model_group';
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
            [['parts_book_id', 'name', 'key'], 'required'],
            [['parts_book_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'key'], 'string', 'max' => 255],
            [['parts_book_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartsBook::className(), 'targetAttribute' => ['parts_book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parts_book_id' => 'Parts Book ID',
            'name' => 'Name',
            'key' => 'Key',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Models]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        return $this->hasMany(Model::className(), ['model_id' => 'id']);
    }

    /**
     * Gets query for [[PartsBook]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartsBook()
    {
        return $this->hasOne(PartsBook::className(), ['id' => 'parts_book_id']);
    }
}
