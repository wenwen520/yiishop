<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($login,'username');
echo $form->field($login,'password')->passwordInput();
echo $form->field($login,'code')->widget(\yii\captcha\Captcha::className());
echo $form->field($login,'remember')->checkbox();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();