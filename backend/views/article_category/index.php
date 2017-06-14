<?=\yii\bootstrap\Html::a('添加',['article_category/add'],['class'=>'btn btn-info btn-xs'])?>
<table class="table">
    <tr>
        <td>ID</td>
        <td>分类名称</td>
        <td>分类简介</td>
        <td>排序</td>
        <td>状态</td>
        <td>类型</td>
        <td>操作</td>
    </tr>
    <?php foreach($article_categores as $article_category):?>
        <tr>
            <td><?=$article_category->id?></td>
            <td><?=$article_category->name?></td>
            <td><?=$article_category->intro?></td>
            <td><?=$article_category->sort?></td>
            <td><?=\backend\models\Article_category::$status[$article_category->status]?></td>
            <td><?=\backend\models\Article_category::$is_help[$article_category->is_help]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['article_category/edit','id'=>$article_category->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['article_category/delete','id'=>$article_category->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'lastPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
