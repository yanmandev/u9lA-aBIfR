<?php

namespace app\common\post\dto;

use app\common\post\models\Post;
use Spatie\DataTransferObject\DataTransferObject;

class UpdatePostDto extends DataTransferObject
{
    public Post $post;
    public string $message;
}