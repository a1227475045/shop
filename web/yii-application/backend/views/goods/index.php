<?php
/* @var $this yii\web\View */
?>
<h1>商品的列表</h1>


    <a href="add" class="btn btn-info">商品添加</a>
<table class="table">
    <tr>
        <th colspan="14" style="text-align: right">

            <a href="create" class="btn btn-success " style="text-align: right" >用户注册</a>
            <a href="login" class="btn btn-success right">用户登录</a>
        </th>
    </tr>
        <tr>
        <th>商品编号</th>
        <th>商品名称</th>
        <th>商品货号</th>
        <th>商品图片</th>
        <th>商品分类</th>
        <th>商品品牌</th>
        <th>商品市场价格</th>
        <th>商品本店价格</th>
        <th>商品库存</th>
        <th>商品是否上架</th>
        <th>商品状态</th>
        <th>商品排序</th>
        <th>商品录入时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($goods as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>
            <td><?=\yii\bootstrap\Html::img("$good->nameText",['height'=>50]) ?></td>
            <td><?=$good->goodsCategory->name?></td>
            <td><?=$good->brands->name?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->shop_price?></td>
            <td><?=$good->stock?></td>
            <td><?=\backend\models\Goods::$is_on_sale[$good->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$status[$good->status]?></td>
            <td><?=$good->sort?></td>
            <td><?=date('Y-m-d H:i:s',$good->inputtime)?></td>
            <td>
                <a href="edit?id=<?=$good->id?>&goods_id=<?=$good->id?>" class="btn btn-success">修改</a>
                <a href="del?id=<?=$good->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>


</table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page
]);
?>