<?php

namespace app\models\agconet\service;

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
class ModelGroup extends \app\models\agconet\db\Model
{
    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\ModelGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\ModelGroupQuery(get_called_class());
    }
}
