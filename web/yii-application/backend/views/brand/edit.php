<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\web\JsExpression;
use xj\uploadify\Uploadify;

/* @var $this yii\web\View */
/* @var $model backend\models\Brands */
/* @var $form ActiveForm */
?>
<div class="brand-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($brand, 'name') ?>
        <?= $form->field($brand, 'status')->radioList(
              \backend\models\Brands::$statustext
        ) ?>
    <?=$form->field($brand,'logo')->hiddenInput()?>

    <?php

    echo Html::fileInput('test', NULL, ['id' => 'test']);
    echo Uploadify::widget([
        'url' => yii\helpers\Url::to(['s-upload']),
        'id' => 'test',
        'csrf' => true,
        'renderTag' => false,
        'jsOptions' => [
            'width' => 120,
            'height' => 40,
            'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
            ),
            'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $("#brand-logo").val(date,fileUrl); 
    }
}
EOF
            ),
        ]
    ]);
    ?>
        <?= $form->field($brand, 'sort') ?>
        <?= $form->field($brand, 'content') ?>
    
        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- brand-add -->
