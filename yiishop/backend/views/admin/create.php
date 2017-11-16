<h1 style="font-family: 'Serif Pro'">管理员添加</h1>
<hr>
<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username');
echo $form->field($model,'password');
echo $form->field($model,'email');
echo $form->field($model,'role')->checkboxList($role);
echo \yii\bootstrap\Html::submitButton('注册',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

?>