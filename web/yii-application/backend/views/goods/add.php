<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model,'sn')->hiddenInput()?>
    <?= $form->field($model, 'goods_category_id')->dropDownList($options[1],['prompt'=>'请选择商品分类']) ?>
    <?= $form->field($model, 'brand_id')->dropDownList($options[0],['prompt'=>'请选择商品品牌']) ?>
    <?= $form->field($model, 'is_on_sale')->radioList(\backend\models\Goods::$is_on_sale) ?>
    <?= $form->field($model, 'status')->radioList(\backend\models\Goods::$status) ?>
    <?= $form->field($model, 'stock') ?>
    <?= $form->field($model, 'sort') ?>
    <?= $form->field($model, 'market_price') ?>
    <?= $form->field($model, 'shop_price') ?>

    <?php
    echo $form->field($model, 'logo')->widget('manks\FileInput', [
    ]);
    // ActiveForm
    echo $form->field($photo, 'path')->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            /* 'server' => Url::to('upload/u2'),
             'accept' => [
             	'extensions' => 'png',*/
        ],
    ]); ?>
    <?= $form->field($intro,'content')->widget('kucha\ueditor\UEditor',[]);?>
    <div class="form-group">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
