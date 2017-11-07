<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($article, 'name') ?>
    <?=$form->field($article,'category_id')->dropDownList(
            [\backend\models\Article::$category_id],['prompt'=>'请选择文章分类']
    )?>
        <?= $form->field($article, 'status')->radioList([
        0=>'不显示',
        1=>'显示'
        ]) ?>
        <?= $form->field($article, 'sort') ?>
        <?= $form->field($article, 'intro') ?>
        <?= $form->field($article_detaile, 'content')->textarea(['rows',6]) ?>

        <div class="form-group">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-add -->
