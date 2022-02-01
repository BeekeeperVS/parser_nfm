<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_model".
 *
 * @property int $id
 * @property string|null $external_id
 * @property int $series_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcScheme[] $ncSchemes
 * @property NcSection[] $ncSections
 * @property NcSeries $series
 */
class NcModel extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_model';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['series_id', 'name'], 'required'],
            [['series_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['external_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 191],
            [['external_id'], 'unique'],
            [['series_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcSeries::className(), 'targetAttribute' => ['series_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'series_id' => 'Series ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[NcSchemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSchemes()
    {
        return $this->hasMany(NcScheme::className(), ['model_id' => 'id']);
    }

    /**
     * Gets query for [[NcSections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSections()
    {
        return $this->hasMany(NcSection::className(), ['model_id' => 'id']);
    }

    /**
     * Gets query for [[Series]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasOne(NcSeries::className(), ['id' => 'series_id']);
    }
}
