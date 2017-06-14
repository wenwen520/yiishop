<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'goods_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Goods::find()->all(),'id','name'),['prompt'=>'请选择商品']);
echo $form->field($model,'imgFile')->fileInput();
echo \yii\bootstrap\Html::submitButton('添加图片',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
