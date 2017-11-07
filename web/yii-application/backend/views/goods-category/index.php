<?php
/* @var $this yii\web\View */
?>

<h1>商品无限极分类</h1>
<a href="add" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>层级编号</th>
        <th>层级名称</th>
        <th>层级简介</th>
        <th>操作</th>
    </tr>

    <?php foreach ($cates as $cate):?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->nameText?></td>
            <td><?=$cate->intro?></td>
            <td>
                <a href="edit?id=<?=$cate->id?>" class="btn btn-success">修改</a>
                <a href="del?id=<?=$cate->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>


</table>
