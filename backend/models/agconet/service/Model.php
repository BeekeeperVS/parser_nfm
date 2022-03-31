<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_model".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property string $site_id
 * @property int $book_id
 * @property string|null $first_page_id
 * @property string $key
 * @property int|null $status
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ModelGroup $model
 * @property Scheme[] $schemes
 */
class Model extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_model';
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
            [['model_id', 'name', 'site_id', 'book_id', 'key'], 'required'],
            [['model_id', 'book_id', 'status', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'site_id', 'first_page_id', 'key'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelGroup::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'name' => 'Name',
            'site_id' => 'Site ID',
            'book_id' => 'Book ID',
            'first_page_id' => 'First Page ID',
            'key' => 'Key',
            'status' => 'Status',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery|\app\models\agconet\query\ModelGroupQuery
     */
    public function getModel()
    {
        return $this->hasOne(ModelGroup::className(), ['id' => 'model_id']);
    }

    /**
     * Gets query for [[Schemes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\agconet\query\SchemeQuery
     */
    public function getSchemes()
    {
        return $this->hasMany(Scheme::className(), ['model_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\ModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\ModelQuery(get_called_class());
    }
}
