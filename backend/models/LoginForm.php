<?php
namespace backend\models;

use yii\base\Model;

//登录表单模型
class LoginForm extends Model
{
    public $username;//用户名
    public $password;//密码



    //验证规则
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            //自定义登录规则
            ['username', 'validateLogin']
        ];

    }

    public function attributeLabels()
    {

        return [

            'username' => '用户名',
            'password' => '密码',
        ];

    }


       // 自定义登录规则
    public function validateLogin(){
        //通过帐号查找用户
       $admin = Admin::findOne(['username'=>$this->username]);

        if($admin){
            //把密码加密
            $old_password=\Yii::$app->security->generatePasswordHash($this->password);
            //验证明文和密文
            $old_pwd = \Yii::$app->security->validatePassword($this->password,$old_password);
            //验证密码
            if($old_pwd == $this->password){
                //密码正确  登录
                \Yii::$app->user->login($admin);
            }else{
                return $this->addError('username','用户名或密码错误');
            }

        }else{
            return $this->addError('username','用户名或密码错误');
        }

    }



}