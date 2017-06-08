<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'article_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Article::find()->all(),'id','name'),['prompt'=>'请选择文章']);
echo $form->field($model,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();