<?php

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
echo \yii\bootstrap\Html::a('回到首页',['index'],['class'=>'btn btn-danger']);
\yii\bootstrap\ActiveForm::end();