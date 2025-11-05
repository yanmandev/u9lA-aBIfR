<?php

namespace app\common\post\services;

use yii\base\Security;
use app\common\post\models\Post;
use app\common\post\dto\CreatePostDto;

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

        return $post;
    }

    public function edit()
    {
    }

    public function remove()
    {
    }
}