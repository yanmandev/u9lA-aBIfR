<?php

namespace app\forms;

use yii\base\Model;
use app\common\post\models\Post;
use app\common\post\dto\UpdatePostDto;

class UpdatePostForm extends Model
{
    public ?string $message = null;

    private Post $post;

    public function __construct(Post $post, $config = [])
    {
        parent::__construct($config);

        $this->post = $post;
    }

    public function rules(): array
    {
        return [
            [['message'], 'filter', 'filter' => 'trim', 'skipOnEmpty' => true],
            [['message'], 'required'],

            ['message', 'string', 'min' => 5, 'max' => 1_000],
            ['message', 'filter', 'filter' => function ($value) {
                $config = \HTMLPurifier_Config::createDefault();
                $config->set('HTML.AllowedElements', ['b', 'i', 's']);
                $config->set('HTML.AllowedAttributes', []);

                $purifier = new \HTMLPurifier($config);

                return $purifier->purify($value);
            }],

            ['message', 'validatePost'],
        ];
    }

    public function validatePost(string $attribute)
    {
        if (!$this->post->canUpdate()) {
            $this->addError($attribute, t('app', 'The post cannot be edited.'));
        }
    }

    public function createDto(): UpdatePostDto
    {
        return new UpdatePostDto([
            'post' => $this->post,
            'message' => $this->message,
        ]);
    }
}