<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>
<a href="add" class="btn btn-info">权限添加</a>
<table class="table">
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>权限生日</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
<?php foreach ($permissions as $permission):?>
    <tr>
        <td><?=$permission->name?></td>
        <td><?php echo strpos($permission->name,"/")?"--":"";?>
            <?=$permission->description?>
        </td>
        <td><?=date('Y-m-d H:i:s',$permission->createdAt)?></td>
        <td><?=date('Y-m-d H:i:s',$permission->updatedAt)?></td>
        <td><?php
            echo \yii\bootstrap\Html::a('编辑',['edit','name'=>$permission->name],['class'=>'btn btn-success']);
            echo \yii\bootstrap\Html::a('删除',['del','name'=>$permission->name],['class'=>'btn btn-danger']);
            ?>
        </td>
    </tr>
<?php endforeach;?>
</table>
