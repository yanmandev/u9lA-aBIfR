<?php

namespace app\behaviors;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    public $createdAtAttribute = 'created_at';
    public $updatedAtAttribute = 'updated_at';

    public function init()
    {
        parent::init();

        if (empty($this->value)) {
            $this->value = time();
        }
    }
}