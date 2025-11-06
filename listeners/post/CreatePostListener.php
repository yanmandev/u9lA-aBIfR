<?php

namespace app\listeners\post;

use yii\helpers\Url;
use app\common\post\events\CreatePostEvent;

class CreatePostListener
{
    public static function handle(CreatePostEvent $event)
    {
        $post = $event->post;

        $mailer = \Yii::$app->mailer;

        $editLink = Url::to(['site/edit', 'id' => $post->unique_id], true);
        $deleteLink = Url::to(['site/delete', 'id' => $post->unique_id], true);

        $mailer
            ->compose(
                'post/create',
                [
                    'name' => $post->name,
                    'email' => $post->email,
                    'message' => $post->email,
                    'editLink' => $editLink,
                    'deleteLink' => $deleteLink,
                ]
            )
            ->setFrom(['noreply@example.com' => 'Story Post'])
            ->setTo($post->email)
            ->setSubject('Your post has been created successfully!')
            ->send();
    }
}