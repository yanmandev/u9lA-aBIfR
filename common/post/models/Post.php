<?php

namespace app\common\post\models;

use app\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property string $unique_id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $ip
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_ARCHIVED = 2;

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isArchived(): bool
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    public static function find(): PostQuery
    {
        return new PostQuery(get_called_class());
    }

    public function behaviors(): array
    {
        return [
            'ts' => TimestampBehavior::class,
        ];
    }

    public static function tableName(): string
    {
        return '{{%post}}';
    }
}
