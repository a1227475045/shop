<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */
/* @var $form ActiveForm */
?>
<div class="article-category-add">

    <?php $form = ActiveForm::begin(); ?>
         <?= $form->field($article, 'cate_name') ?>
        <?= $form->field($article, 'intro') ?>
        <?= $form->field($article, 'status')->radioList(
            \backend\models\ArticleCategory::$statustext
        ) ?>
        <?= $form->field($article, 'sort') ?>

    <?= $form->field($article, 'is_help')->radioList(
            \backend\models\ArticleCategory::$is_helptext
    ) ?>
    
        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-category-add -->
