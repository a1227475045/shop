<?php
/* @var $this yii\web\View */
?>
<h1>管理员表</h1>
<a href="create" class="btn btn-info">添加管理员</a>
<table class="table">
    <tr>
        <th>管理员编号</th>
        <th>管理账户</th>
        <th>管理邮箱</th>
        <th>管理员创建时间</th>
        <th>管理员最后登录时间</th>
        <th>管理员最后登录IP</th>
        <th>操作</th>
    </tr>

    <?php foreach ($users as $user):?>
        <tr>
            <td><?=$user->id?></td>
            <td><?=$user->username?></td>
            <td><?=$user->email?></td>
            <td><?=date('Y-m-d H:i:s',$user->add_time)?></td>
            <td><?=date('Y-m-d H:i:s',$user->last_login_time)?></td>
            <td><?=$user->last_login_ip?></td>
            <td>
                <a href="edit?id=<?=$user->id?>" class="btn btn-success">编辑</a>
                <a href="del?id=<?=$user->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>

</table>
