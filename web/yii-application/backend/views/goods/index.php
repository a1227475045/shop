<?php
/* @var $this yii\web\View */
?>
<h1>商品的列表</h1>

<div class="row">
        <div class="col-md-2"><?=\yii\bootstrap\Html::a("添加",['add'],['class'=>'btn btn-info'])?></div>
        <div class="col-md-10">
             <form class="form-inline pull-right" method="get" >
            <input type="text" class="form-control" id="minPrice" name="minPrice" size="8" placeholder="最低价" value="<?=Yii::$app->request->get('minPrice')?>"> -
            <input type="text" class="form-control" id="maxPrice" name="maxPrice"  size="8" placeholder="最高价" value="<?=Yii::$app->request->get('maxPrice')?>">
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入商品名称或货号" value="<?=Yii::$app->request->get('keyword')?>">
            <button type="submit" class="btn btn-default">搜索</button>
        </form>


        </div>
    </div>
    <table class="table">
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