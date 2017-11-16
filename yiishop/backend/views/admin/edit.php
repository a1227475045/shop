<h1 style="font-family: 'Serif Pro'">管理员信息修改</h1>
<hr>
<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username');
echo $form->field($model,'password');
echo $form->field($model,'email');
echo $form->field($model,'role')->checkboxList($role,['prompt' =>$model->authAssignment->item_name]);
echo \yii\bootstrap\Html::submitButton('修改',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

?>