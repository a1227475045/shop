<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\web\JsExpression;
use xj\uploadify\Uploadify;



/* @var $this yii\web\View */
/* @var $model backend\models\Brands */
/* @var $form ActiveForm */
?>
<div class="brand-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($brand, 'name') ?>
        <?= $form->field($brand, 'status')->inline()->radioList(
              \backend\models\Brands::$statustext
        ) ?>
        <?=$form->field($brand,'logo')->widget('manks\FileInput', []); ?>


        <?= $form->field($brand, 'sort') ?>
        <?= $form->field($brand, 'content') ?>
    
        <div class="form-group">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- brand-add -->
