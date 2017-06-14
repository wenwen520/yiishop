<?=\yii\bootstrap\Html::a('添加图片',['album/add'],['class'=>'btn btn-info'])?>

<table class="table">
    <tr>
        <th>图片ID</th>
        <th>商品名</th>
        <th>商品图片</th>
        <th>操作</th>
    </tr>
    <?php foreach($album as $photo):?>
        <tr>
            <td><?=$photo->id?></td>
            <td><?=$photo->goods->name?></td>
            <td><?=\yii\bootstrap\Html::img(($photo->photo),['style'=>'width:100px'])?></td>
            <td><?=\yii\helpers\Html::a('删除',['album/delete','id'=>$photo->id],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
]);