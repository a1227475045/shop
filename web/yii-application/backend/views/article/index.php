<?php
/* @var $this yii\web\View */
?>
<h1>文章列表</h1>
<a href="add" class="btn btn-info">悄悄咩咩的添加一篇骚文章</a>
<table class="table">
    <tr>
        <th>文章编号</th>
        <th>文章名称</th>
        <th>文章分类</th>
        <th>文章简介</th>
        <th>文章状态</th>
        <th>文章排序</th>
        <th>文章内容</th>
        <th>文章生日</th>
        <th>操作</th>
    </tr>

    <?php foreach ($articles as $article):?>
        <tr>
            <td><?=$article['id']?></td>
            <td><?=$article['name']?></td>
            <td><?=$article->articleCategory->cate_name?></td>
            <td><?=$article['intro']?></td>
            <td><?=\backend\models\Article::$status[$article['status']]?></td>
            <td><?=$article['sort']?></td>
            <td><?=substr($article['content'],0,30)?></td>
            <td><?=date('Y-m-d H:i:s',$article['create_time'])?></td>
            <td>
                <a href="edit?id=<?=$article['id']?>" class="btn btn-success">编辑</a>
                <a href="del?id=<?=$article['id']?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>


</table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page
]);
?>