<?php

namespace app\common\post\services;

use yii\base\Event;
use yii\base\Security;
use app\common\post\models\Post;
use app\common\post\dto\CreatePostDto;
use app\common\post\dto\UpdatePostDto;
use app\common\post\events\CreatePostEvent;

class PostService
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function add(CreatePostDto $dto): Post
    {
        $post = new Post();
        $post->unique_id = $this->security->generateRandomString();
        $post->name = $dto->name;
        $post->email = $dto->email;
        $post->message = $dto->message;
        $post->ip = $dto->ip;
        $post->status = Post::STATUS_PUBLISHED;

        if (!$post->save(false)) {
            throw new \LogicException("Invalid post creation.");
        }

        Event::trigger(CreatePostEvent::class, CreatePostEvent::class, CreatePostEvent::obtain($post));

        return $post;
    }

    public function edit(UpdatePostDto $dto)
    {
        $post = $dto->post;

        if (!$post->canUpdate()) {
            throw new \LogicException("The post cannot be edited.");
        }

        $post->message = $dto->message;
        $post->update(false);
        $post->refresh();
    }

    public function delete(Post $post)
    {
        if (!$post->canDelete()) {
            throw new \LogicException("The post cannot be deleted.");
        }

        $post->status = Post::STATUS_ARCHIVED;
        $post->update(false);
        $post->refresh();
    }
}