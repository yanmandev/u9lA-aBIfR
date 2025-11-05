<?php

namespace app\common\post\dto;

use Spatie\DataTransferObject\DataTransferObject;

class CreatePostDto extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $message;
    public string $ip;
}