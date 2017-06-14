<?php
use yii\web\JsExpression;



$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();

echo $form->field($model,'logo')->hiddenInput();

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
        $('#brand-logo').val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);

if($model->logo){
    echo  yii\helpers\Html::img('@web'.$model->logo,['width'=>50]);
}else{
    echo  yii\helpers\Html::img('',['style'=>'display:none','width'=>50,'id'=>'img_logo']);
}

echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(['0'=>'隐藏','1'=>'正常']);
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();