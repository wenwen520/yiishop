<?php
namespace backend\models;

use yii\base\Model;

//登录表单模型
class LoginForm extends Model
{
    public $username;//用户名
    public $password;//密码
    public $code;
    public $cookie;



    //验证规则
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            //自定义登录规则
            ['username', 'validateLogin'],
            ['cookie','safe'],
            ['code','captcha']

        ];

    }

    public function attributeLabels()
    {

        return [

            'username' => '用户名',
            'password' => '密码',
            'cookie'=>'自动登录',
            'code'=>'验证码',
        ];

    }


       // 自定义登录规则
    public function validateLogin()
    {
        //通过帐号查找用户
        $admin = Admin::findOne(['username' => $this->username]);

        if ($admin) {
            //验证密码
            if (\Yii::$app->security->validatePassword($this->password, $admin->password)) {

                //自动登录
                $admin->generateAuthKey();
                $admin->save(false);
                $cookie = \Yii::$app->user->authTimeout;
                //密码正确  登录
                \Yii::$app->user->login($admin,$this->cookie?$cookie:0);

            } else {

                return $this->addError('username', '用户名或密码错误');
            }

        } else {
            return $this->addError('username', '用户名或密码错误');
        }

    }




}