<?php

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn sm']);
\yii\bootstrap\ActiveForm::end();


//使用ztree  就要加载资源
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);

 $this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');

$zNodes = yii\helpers\Json::encode($categories);
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
            onClick:function(event,treeId,treeNode){
                //console.debug(treeNode.id);//获取点击的对象的id
                //将获取的id赋值给表单parent_id字段
                $('#goods_category-parent_id').val(treeNode.id);
            }
        }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};
    $(document).ready(function(){
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);//展开所有节点
        //根据id 获取当前节点的父节点
        var Pid=zTreeObj.getNodeByParam('id',$('#goods_category-parent_id').val(),null);
        //选中当前节点的父节点
        zTreeObj.selectNode(Pid);

    });
JS

);
$this->registerJs($js);

?>
