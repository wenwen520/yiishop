<?php
echo \yii\bootstrap\Html::beginForm(['goods/index'],'get');
echo \yii\bootstrap\Html::textInput('name','',['placeholder'=>'名称']);
echo \yii\bootstrap\Html::textInput('sn','',['placeholder'=>'货号']);
echo \yii\bootstrap\Html::submitInput('搜索');
echo \yii\bootstrap\Html::endForm();
?>
<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-info btn-sm'])?>



    <table class="table table-bordered table-striped">
        <tr>
            <td>ID</td>
            <td>商品名称</td>
            <td>编号</td>
            <td>图片</td>
            <td>所属分类</td>
            <td>所属商品</td>
            <td>市场售价</td>
            <td>实际价格</td>
            <td>库存</td>
            <td>是否在售</td>
            <td>状态</td>
            <td>排序</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        <?php foreach($models as $model):?>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->sn?></td>
                <td><?=$model->logo?\yii\bootstrap\Html::img($model->logo,['width'=>50]):''?></td>
                <td><?=$model->goods_category->name?></td>
                <td><?=$model->brand->name?></td>
                <td><?=$model->market_price?></td>
                <td><?=$model->shop_price?></td>
                <td><?=$model->stock?></td>
                <td><?=\backend\models\Goods::$is_on_sale [$model->is_on_sale]?></td>
                <td><?=\backend\models\Goods::$status[$model->status]?></td>
                <td><?=$model->sort?></td>
                <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('查看相册',['goods/album','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
                    <?=\yii\bootstrap\Html::a('商品详情',['goods/intro','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
                    <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php

echo \yii\widgets\LinkPager::widget(
    [ 'pagination'=>$page,
        'nextPageLabel'=>'下一页',
        'prevPageLabel'=>'上一页',
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
        'options'=>['class'=>'pagination','style'=>'padding-left:30%'
        ]
    ]);