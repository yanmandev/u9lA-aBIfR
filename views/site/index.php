<?php

use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\bootstrap5\ActiveForm;
use app\helpers\TextHelper;
use app\helpers\DateHelper;
use app\helpers\IpHelper;

/** @var yii\web\View $this */
/** @var app\forms\CreatePostForm $model */
/** @var app\common\post\models\Post[] $posts */
/** @var array $postCounts */

$this->title = 'Story Post';
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-8" style="padding-top: 0.5em">
            <?php foreach ($posts as $post): ?>
                <div class="card card-default mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post->name ?></h5>
                        <p><?= $post->message ?></p>
                        <p>
                            <small class="text-muted">
                                <?= DateHelper::dateForHumans($post->created_at) ?> |
                                <?= IpHelper::mask($post->ip) ?> |
                                <?= $postCounts[$post->ip] . ' ' . TextHelper::plural($postCounts[$post->ip], 'posts', 'post', 'posts', 'posts') ?>
                            </small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'post',
            ]); ?>

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'message')->textarea() ?>

            <?= $form->field($model, 'captcha')->widget(Captcha::class, []) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
