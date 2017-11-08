<?php
/* @var $this yii\web\View */
?>

<h1>商品无限极分类</h1>
<a href="add" class="btn btn-info">添加</a>
<table class="table" >
    <tr>
        <th>层级编号</th>
        <th>层级名称</th>
        <th>层级简介</th>
        <th>操作</th>
    </tr>

    <?php foreach ($cates as $cate):?>
        <tr data-lft="<?=$cate->lft?>" data-rgt="<?=$cate->rgt?>" data-tree="<?=$cate->tree?>">
            <td><?=$cate->id?></td>
            <td>
                <span class="glyphicon glyphicon-collapse-down cate"></span><?=$cate->nameText?>
            </td>
            <td><?=$cate->intro?></td>
            <td>
                <a href="edit?id=<?=$cate->id?>" class="btn btn-success">修改</a>
                <a href="del?id=<?=$cate->id?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>


</table>

<?php
$js=<<<EOF

$(".cate").click(function(){
 var tr=$(this).parent().parent();
 var lft=tr.attr('data-lft');
 var rgt=tr.attr('data-rgt');
 var tree=tr.attr('data-tree')
 
  var trs=$("tr")
  $.each(trs,function(k,v){
  var treePer=$(v).attr('data-tree')
  var rgtPer=$(v).attr('data-rgt')
  var lftPer=$(v).attr('data-lft')
  console.log(treePer,rgtPer,lftPer);
    if(tree==treePer && lftPer-lft>0 && rgtPer-rgt<0){
        $(v).toggle();
    }
  });

})

EOF;
$this->registerJs($js);
?>

