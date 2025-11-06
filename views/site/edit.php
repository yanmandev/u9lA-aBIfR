<?php

use Carbon\Carbon;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\common\post\models\Post $post */
/** @var app\forms\CreatePostForm $model */

$this->title = 'Story Post Edit';
?>
<div class="site-index">
    <div class="row">
        <div class="col">
            <h3>Edit post</h3>
        </div>
        <div class="col" style="text-align: right">
            <?php if ($post->canDelete()): ?>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal"
                    data-post-id="123">
                Delete post
            </button>
            <?php endif; ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $post,
        'attributes' => [
            [
                'label' => 'ID',
                'format' => 'html',
                'value' => $post->unique_id,
            ],
            [
                'label' => 'Name',
                'format' => 'html',
                'value' => $post->name,
            ],
            [
                'label' => 'Email',
                'format' => 'html',
                'value' => $post->email,
            ],
            [
                'label' => 'Created At',
                'format' => 'html',
                'value' => Carbon::createFromTimestamp($post->created_at, 'utc')->setTimezone('Europe/Moscow')->format('d.m.Y H:i'),
            ],
        ],
    ]) ?>

    <?php if ($post->canUpdate()): ?>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
        ]); ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 5]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmation of deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this post?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form id="form-delete" method="post"
                          action="<?= \yii\helpers\Url::to(['site/delete', 'id' => $post->unique_id]) ?>">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
