<?php

namespace app\bootstrap;

use yii\base\Event;
use yii\base\BootstrapInterface;
use app\common\post\events\CreatePostEvent;
use app\listeners\post\CreatePostListener;

class EventBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Event::on(
            CreatePostEvent::class,
            CreatePostEvent::class,
            [CreatePostListener::class, 'handle']
        );
    }
}