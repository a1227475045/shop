<a href="add" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>品牌编号</th>
        <th>品牌名称</th>
        <th>品牌LOGO</th>
        <th>品牌状态</th>
        <th>品牌排序</th>
        <th>品牌简介</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=\yii\bootstrap\Html::img("@web/$brand->logo",['height'=>50]) ?></td>
            <td><?=\backend\models\Brands::$statustext[$brand->status]?></td>
            <td><?=$brand->sort?></td>
            <td><?=$brand->content?></td>
            <td><?=date('Y-m-d H:i:s',$brand->create_time)?></td>
            <td>
                <a href="edit?id=<?=$brand->id?>" class="btn btn-success">编辑</a>
                <a href="del?id=<?=$brand->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
        'pagination'=>$page
]);
?>