<?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-info btn-sm'])?>
<table class="table">
    <tr>
        <td>ID</td>
        <td>文章名称</td>
        <td>简介</td>
        <td>分类id</td>
        <td>排序</td>
        <td>状态</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->intro?></td>
            <td><?=$article->article_category->name?></td>
            <td><?=$article->sort?></td>
            <td><?=$article->status?></td>
            <td><?=date('Y-d-m G:i:s',$article->create_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看文章详情',['article/detail','id'=>$article->id],['class'=>'btn btn-info btn-xs'])?>
                <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$article->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$article->id],['class'=>'btn btn-danger btn-xs'])?>

            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'lastPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
]);