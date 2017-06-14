<?php
namespace backend\models;

//修改密码模型表单

use yii\base\Model;


class AdminPwd extends Model
{
    public $password;//旧密码
    public $newpassword;//新密码
    public $repassword;//确认新密码


    //验证规则
    public function rules()
    {
        return [
            [['password', 'newpassword', 'repassword'], 'required'],
            //  第二种方法   自定义验证密码规则
            ['password', 'validatePwd'],
            // 第二种方法  认证两次新密码是否一致
            ['repassword', 'compare', 'compareAttribute' => 'newpassword', 'message' => '输入的两次密码不一致'],
        ];
    }

    //标签属性
    public function attributeLabels()
    {
        return [
            'password' => '旧密码',
            'newpassword' => '新密码',
            'repassword' => '确认新密码',
        ];
    }


}

