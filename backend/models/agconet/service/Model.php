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
class Model extends \app\models\agconet\db\Model
{
    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\ModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\ModelQuery(get_called_class());
    }
}
