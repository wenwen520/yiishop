<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();