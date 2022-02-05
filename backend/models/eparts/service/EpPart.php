<?php

namespace app\models\eparts\service;

use Yii;

/**
 * This is the model class for table "ep_part".
 *
 * @property int $id
 * @property int $assembly_id
 * @property string|null $ep_id
 * @property string|null $number
 * @property string|null $description
 * @property string|null $quantity
 * @property string|null $reference_number
 * @property string|null $sequence_number
 * @property string|null $sku_global
 * @property string|null $substitution_code
 * @property string|null $substitution_type
 * @property string|null $technical_description
 * @property string|null $image
 * @property string|null $technical_image
 * @property string|null $ep_assembly_id
 * @property string|null $ep_assembly_part_list_id
 * @property string|null $details
 * @property string|null $substitutions
 * @property string|null $kits
 * @property int|null $alternative_indicator
 * @property int|null $component_indicator
 * @property int|null $is_in_working_list
 * @property int|null $kit_indicator
 * @property int|null $notes
 * @property int|null $reman_indicator
 * @property int|null $substitution_indicator
 * @property string|null $usage
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpAssembly $assembly
 */
class EpPart extends \app\models\eparts\db\EpPart
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_part';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assembly_id'], 'required'],
            [['assembly_id', 'alternative_indicator', 'component_indicator', 'is_in_working_list', 'kit_indicator', 'notes', 'reman_indicator', 'substitution_indicator', 'status_parser'], 'integer'],
            [['technical_description', 'image', 'technical_image'], 'string'],
            [['details', 'substitutions', 'kits', 'created_at', 'updated_at'], 'safe'],
            [['ep_id', 'number', 'description', 'quantity', 'reference_number', 'sequence_number', 'sku_global', 'substitution_code', 'substitution_type', 'ep_assembly_id', 'ep_assembly_part_list_id', 'usage'], 'string', 'max' => 255],
            [['assembly_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpAssembly::className(), 'targetAttribute' => ['assembly_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assembly_id' => 'Assembly ID',
            'ep_id' => 'Ep ID',
            'number' => 'Number',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'reference_number' => 'Reference Number',
            'sequence_number' => 'Sequence Number',
            'sku_global' => 'Sku Global',
            'substitution_code' => 'Substitution Code',
            'substitution_type' => 'Substitution Type',
            'technical_description' => 'Technical Description',
            'image' => 'Image',
            'technical_image' => 'Technical Image',
            'ep_assembly_id' => 'Ep Assembly ID',
            'ep_assembly_part_list_id' => 'Ep Assembly Part List ID',
            'details' => 'Details',
            'substitutions' => 'Substitutions',
            'kits' => 'Kits',
            'alternative_indicator' => 'Alternative Indicator',
            'component_indicator' => 'Component Indicator',
            'is_in_working_list' => 'Is In Working List',
            'kit_indicator' => 'Kit Indicator',
            'notes' => 'Notes',
            'reman_indicator' => 'Reman Indicator',
            'substitution_indicator' => 'Substitution Indicator',
            'usage' => 'Usage',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Assembly]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpAssemblyQuery
     */
    public function getAssembly()
    {
        return $this->hasOne(EpAssembly::className(), ['id' => 'assembly_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\query\EpPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\eparts\query\EpPartQuery(get_called_class());
    }
}
