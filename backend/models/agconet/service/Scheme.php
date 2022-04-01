<?php

namespace app\models\agconet\service;

use components\parser\agconet\steps\Schemes;
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
class Scheme extends \app\models\agconet\db\Scheme
{
    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\SchemeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\SchemeQuery(get_called_class());
    }
}
