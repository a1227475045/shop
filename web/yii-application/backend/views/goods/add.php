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

        <?= $form->field($model, 'goods_category_id')->dropDownList($options,['prompt'=>'请选择商品分类']) ?>
        <?= $form->field($model, 'brand_id')->dropDownList($brands,['prompt'=>'请选中商品品牌']) ?>
        <?= $form->field($model, 'is_on_sale')->radioList(\backend\models\Goods::$is_on_sale) ?>
        <?= $form->field($model, 'status')->radioList(\backend\models\Goods::$status) ?>
    <?= $form->field($model, 'stock') ?>
        <?= $form->field($model, 'sort') ?>
        <?= $form->field($model, 'market_price') ?>
        <?= $form->field($model, 'shop_price') ?>
    <?=$form->field($model,'logo')->widget('manks\FileInput', []); ?>
        <?=$form->field($model,'content')->textarea(['rows'=>6])?>
        <div class="form-group">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
