<?php

namespace app\common\post\events;

use yii\base\Event;
use app\common\post\models\Post;

class CreatePostEvent extends Event
{
    public Post $post;

    public static function obtain(Post $post): self
    {
        $event = new self();
        $event->post = $post;

        return $event;
    }
}