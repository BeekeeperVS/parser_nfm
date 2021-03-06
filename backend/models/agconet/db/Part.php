<?php

namespace app\models\agconet\db;

use Yii;

/**
 * This is the model class for table "agc_part".
 *
 * @property int $id
 * @property int $scheme_id
 * @property string $name
 * @property string $key
 * @property string $article
 * @property int $quantity
 * @property int|null $item_id
 * @property string|null $specification
 * @property string|null $detail_parser
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Scheme $scheme
 */
class Part extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_part';
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
            [['scheme_id', 'name', 'key'], 'required'],
            [['scheme_id', 'quantity', 'item_id', 'status_parser'], 'integer'],
            [['detail_parser', 'created_at', 'updated_at'], 'safe'],
            [['name', 'key', 'article', 'specification'], 'string', 'max' => 255],
            [['scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Scheme::className(), 'targetAttribute' => ['scheme_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scheme_id' => 'Scheme ID',
            'name' => 'Name',
            'key' => 'Key',
            'article' => 'Article',
            'quantity' => 'Quantity',
            'item_id' => 'Item ID',
            'specification' => 'Specification',
            'detail_parser' => 'Detail Parser',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Scheme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheme()
    {
        return $this->hasOne(Scheme::className(), ['id' => 'scheme_id']);
    }
}
