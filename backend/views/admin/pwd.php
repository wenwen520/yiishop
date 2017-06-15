<?php
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'newpassword')->passwordInput();
echo $form->field($model,'repassword')->passwordInput();
echo \yii\bootstrap\Html::submitButton('修改密码',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();