<?php

namespace app\models\agconet\db;

use Yii;

/**
 * This is the model class for table "agc_scheme".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property string $key
 * @property string|null $parent_key
 * @property int $level
 * @property int|null $has_child
 * @property string|null $site_id
 * @property string|null $page_info
 * @property string|null $display
 * @property string|null $display_short
 * @property int|null $page_number
 * @property string|null $image_url
 * @property string|null $image_data
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Model $model
 * @property Scheme $parentKey
 * @property Part[] $parts
 * @property Scheme[] $schemes
 */
class Scheme extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_scheme';
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
            [['model_id', 'name', 'key', 'level'], 'required'],
            [['model_id', 'level', 'has_child', 'page_number', 'status_parser'], 'integer'],
            [['image_data', 'created_at', 'updated_at'], 'safe'],
            [['name', 'key', 'parent_key', 'site_id', 'page_info', 'display', 'display_short', 'image_url'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['parent_key'], 'exist', 'skipOnError' => true, 'targetClass' => Scheme::className(), 'targetAttribute' => ['parent_key' => 'key']],
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
            'key' => 'Key',
            'parent_key' => 'Parent Key',
            'level' => 'Level',
            'has_child' => 'Has Child',
            'site_id' => 'Site ID',
            'page_info' => 'Page Info',
            'display' => 'Display',
            'display_short' => 'Display Short',
            'page_number' => 'Page Number',
            'image_url' => 'Image Url',
            'image_data' => 'Image Data',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }

    /**
     * Gets query for [[ParentKey]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentKey()
    {
        return $this->hasOne(Scheme::className(), ['key' => 'parent_key']);
    }

    /**
     * Gets query for [[Parts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(Part::className(), ['scheme_id' => 'id']);
    }

    /**
     * Gets query for [[Schemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchemes()
    {
        return $this->hasMany(Scheme::className(), ['parent_key' => 'key']);
    }
}
