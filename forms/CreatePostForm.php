<?php

namespace app\forms;

use Carbon\Carbon;
use yii\base\Model;
use app\common\post\dto\CreatePostDto;
use app\common\post\repositories\PostRepository;

class CreatePostForm extends Model
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $message = null;
    public ?string $captcha = null;
    public string $ip;

    private PostRepository $repository;

    public function __construct(PostRepository $repository, $config = [])
    {
        parent::__construct($config);

        $this->repository = $repository;
    }

    public function rules(): array
    {
        return [
            [['name', 'email', 'message', 'captcha'], 'filter', 'filter' => 'trim', 'skipOnEmpty' => true],
            [['name', 'email', 'message', 'captcha'], 'required'],

            ['email', 'email'],

            ['name', 'string', 'min' => 2, 'max' => 15],
            ['name', 'match', 'pattern' => '/^[A-Za-zА-Яа-яЁё0-9_ ]+$/u', 'message' => 'The name can contain only letters, numbers, spaces, and the "_" character.'],

            ['message', 'string', 'min' => 5, 'max' => 1_000],
            ['message', 'filter', 'filter' => function ($value) {
                $config = \HTMLPurifier_Config::createDefault();
                $config->set('HTML.AllowedElements', ['b', 'i', 's']);
                $config->set('HTML.AllowedAttributes', []);

                $purifier = new \HTMLPurifier($config);

                return $purifier->purify($value);
            }],

            ['captcha', 'captcha'],

            ['message', 'validatePost'],
        ];
    }

    public function validatePost(string $attribute)
    {
        $lastPost = $this->repository->getLastPostByIp($this->ip);

        if ($lastPost) {
            $now = Carbon::now('utc');
            $date = Carbon::createFromTimestamp($lastPost->created_at, 'utc');

            if ($date->diffInMinutes($now) < 3) {
                $secondsLeft = 180 - $date->diffInSeconds($now);

                $this->addError($attribute, t('app', "The message can be sent in {$secondsLeft} seconds."));
                return;
            }
        }
    }

    public function createDto(): CreatePostDto
    {
        return new CreatePostDto([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'ip' => $this->ip,
        ]);
    }
}