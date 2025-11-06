<?php

namespace app\common\post\models;

use Carbon\Carbon;
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
    public const STATUS_PUBLISHED = 1;
    public const STATUS_ARCHIVED = 2;

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isArchived(): bool
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    public function canUpdate(): bool
    {
        $now = Carbon::now('utc');
        $date = Carbon::createFromTimestamp($this->created_at, 'utc');

        return $this->isPublished() && $date->diffInHours($now) < 12;
    }

    public function canDelete(): bool
    {
        $now = Carbon::now('utc');
        $date = Carbon::createFromTimestamp($this->created_at, 'utc');

        return $this->isPublished() && $date->diffInDays($now) < 14;
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
