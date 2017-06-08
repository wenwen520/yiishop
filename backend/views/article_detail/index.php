<?=\yii\bootstrap\Html::a('添加',['article_detail/add'],['class'=>'btn btn-info btn-xs'])?>
<table class="table">
    <tr>
        <td>文章ID</td>
        <td>文章详情</td>
        <td>操作</td>
    </tr>
    <?php foreach($article_detail as $detail):?>
        <tr>
            <td><?=$detail->article->name?></td>
            <td><?=$detail->content?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['article_detail/edit','article_id'=>$detail->article_id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('删除',['article_detail/delete','article_id'=>$detail->article_id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>