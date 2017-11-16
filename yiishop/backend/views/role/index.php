<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>
<a href="add" class="btn btn-info">角色添加</a>
<table class="table">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>角色权限</th>
        <th>角色生日</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
<?php foreach ($roles as $role):?>
    <tr>
        <td><?=$role->name?></td>
        <td><?=$role->description?></td>
        <td><?php
            //创建RBAC模型对象
            $authManger=Yii::$app->authManager;
            //得到当前角色的所有权限
            $permissions=$authManger->getPermissionsByRole($role->name);
            //循环遍历出所有的权限
            foreach ($permissions as $permission){
                echo "-".$permission->description."-";
            }
            ?></td>
        <td><?=date('Y-m-d H:i:s',$role->createdAt)?></td>
        <td><?=date('Y-m-d H:i:s',$role->updatedAt)?></td>
        <td><?php
            echo \yii\bootstrap\Html::a('编辑',['edit','name'=>$role->name],['class'=>'btn btn-success']);
            echo \yii\bootstrap\Html::a('删除',['del','name'=>$role->name],['class'=>'btn btn-danger']);
            ?>
        </td>
    </tr>
<?php endforeach;?>
</table>
