<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($good,'name');
echo $form->field($good,'parent_id')->hiddenInput();

echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
    callback: {
				onClick: function(event,treeId,treeNode){
				console.dir(treeNode);
				$("#goodscategory-parent_id").val(treeNode.id);
				}
			},
			
			data: {
				simpleData: {
					enable: true,
					idKey: "id",
			        pIdKey: "parent_id",
			        rootPId: 0
				}
			},
			
			edit: {
		enable: true,
		drag: {
			isCopy: false,
			isMove: true
		}
	}
		}',
    'nodes' =>$cates,
]);


echo $form->field($good,'intro');
echo \yii\bootstrap\Html::submitButton("修改",["class"=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();

?>