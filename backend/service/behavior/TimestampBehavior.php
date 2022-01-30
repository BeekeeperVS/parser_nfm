<?php

namespace app\service\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;


class TimestampBehavior extends Behavior
{
    /**
     * @var $create array
     * @var $update array
     * @var $format string
     *
     * @var $owner ActiveRecord
     */

    public $create = ['created_at', 'updated_at'];
    public $update = ['updated_at'];
    public $format = 'datetime';

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'insert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'update',
        ];
    }

    /**
     * Time creation object $owner
     */
    public function insert()
    {
        foreach ($this->create as $item) {
            if (isset($this->owner->{$item})) {
                $this->owner->{$item} = $this->formatter();
            }
        }
    }

    /**
     * Time updating object $owner
     */
    public function update()
    {
        if ($this->update) {
            foreach ($this->update as $item) {
                if (isset($this->owner->{$item})) {
                    $this->owner->{$item} = $this->formatter();
                }
            }
        }
    }

    /**
     * @return string
     */
    private function formatter(): string
    {
        $f = '';
        switch ($this->format) {
            case 'datetime':
                $f = date('Y-m-d H:i:s');
                break;
            case 'date':
                $f = date('Y-m-d');;
                break;
            case 'year':
                $f = date('Y');
                break;
        }
        return $f;
    }
}