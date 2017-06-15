<?php
use \kucha\ueditor\UEditor;
use yii\web\JsExpression;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');

echo $form->field($model,'logo')->hiddenInput(['id='>'goods-logo']);

echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test'],'');
echo xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 100,
        'height' => 20,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //将上传成功后的图片地址写入img标签
        $('#img_logo').attr("src",data.fileUrl).show();
        //将上传成功后的图片地址写入logo字段
        $('#goods-logo').val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);


if($model->logo){
    echo  yii\helpers\Html::img(Yii::getAlias('@web').$model->logo,['width'=>50]);
}else{
    echo  yii\helpers\Html::img('',['style'=>'display:none','width'=>50,'id'=>'img_logo']);
}

//echo $form->field($model,'goods_category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Goods_category::find()->all(),'id','name'),['prompt'=>'请选择商品分类']);
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';

echo $form->field($model,'sort');
echo $form->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Brand::find()->all(),'id','name'),['prompt'=>'请选择品牌']);;
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$is_on_sale);
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$status);
echo $form->field($intro,'content')->widget(kucha\ueditor\UEditor::className());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();

$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes = \yii\helpers\Json::encode(\backend\models\Goods_category::find()->asArray()->all());
$js = new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		    onClick: function(event, treeId, treeNode) {
                //console.log(treeNode.id);
                //将选中节点的id赋值给表单parent_id
                $("#goods-goods_category_id").val(treeNode.id);
            }
	    }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};

    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);//展开所有节点
    //获取当前节点的父节点（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $("#goods-goods_category_id").val(), null);
    zTreeObj.selectNode(node);//选中当前节点的父节点

JS

);

$this->registerJs($js);

