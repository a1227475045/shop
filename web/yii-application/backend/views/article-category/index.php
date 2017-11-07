<?php
/* @var $this yii\web\View */
?>
<h1>分类列表</h1>

<a href="add" class="btn btn-info">添加分类</a>
<table class="table">
    <tr>
        <th>分类编号</th>
        <th>分类名称</th>
        <th>分类简介</th>
        <th>分类排序</th>
        <th>是否需要帮助</th>
        <th>操作</th>
    </tr>

    <?php foreach ($categorys as $category):?>
        <tr>
            <td><?=$category->id?></td>
            <td><?=$category->cate_name?></td>
            <td><?=$category->intro?></td>
            <td><?=$category->status?></td>
            <td><?=$category->sort?></td>
            <td><?=$category->is_help?></td>
            <td>
                <a href="edit?id=<?=$category->id?>" class="btn btn-success">编辑</a>
                <a href="del?id=<?=$category->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>

</table>