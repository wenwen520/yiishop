
<?=\yii\bootstrap\Html::a('添加',['goods_category/add'],['class'=>'btn btn-info btn-sm'])?>


<table class="table">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>上级分类</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach($goods as $g):?>
        <tr>
            <td><?=$g->id?></td>
            <td><?=$g->name?></td>
            <td><?=$g->parent_id==0?'顶级分类':$g->parent->name?></td>
            <td><?=$g->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['goods_category/edit','id'=>$g->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods_category/delete','id'=>$g->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

]);