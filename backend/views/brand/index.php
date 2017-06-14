<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info btn-sm'])?>
<table class="table">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>简介</td>
        <td>LOGO</td>
        <td>排序</td>
        <td>状态</td>
        <td>操作</td>

    </tr>
    <?php foreach($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=$brand->intro?></td>
            <td><?=\yii\bootstrap\Html::img($brand->logo,['width'=>'50','height'=>'50'])?></td>
            <td><?=$brand->sort?></td>
            <td><?= \backend\models\Brand::$status[$brand->status]?></td>

            <td>
                <?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$brand->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$brand->id],['class'=>'btn btn-danger btn-xs'])?>
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