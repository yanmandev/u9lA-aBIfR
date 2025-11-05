<?php

namespace app\controllers;

use yii\web\Session;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\forms\CreatePostForm;
use app\common\post\services\PostService;
use app\common\post\repositories\PostRepository;

class SiteController extends Controller
{
    private PostService $postService;
    private PostRepository $postRepository;
    private Session $session;

    public function __construct($id, $module, PostService $postService, PostRepository $postRepository, Session $session, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->session = $session;
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => null,
            ],
        ];
    }

    public function actionIndex()
    {
        $ip = $this->request->getUserIP();

        $form = new CreatePostForm($this->postRepository);
        $form->ip = $ip;

        if ($this->request->isPost) {
            $form->load($this->request->post());

            if ($form->validate()) {
                $this->postService->add($form->createDto());

                $this->session->setFlash('success', 'The message is published!');

                return  $this->redirect('site/index');
            }
        }

        $posts = $this->postRepository->getPublishedPosts(10);
        $ips = ArrayHelper::getColumn($posts, 'ip');
        $postCounts = $this->postRepository->getPostCounts($ips);

        return $this->render('index', [
            'model' => $form,
            'posts' => $posts,
            'postCounts' => $postCounts,
        ]);
    }
}
