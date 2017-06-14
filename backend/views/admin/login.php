<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($login,'username');
echo $form->field($login,'password');
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();