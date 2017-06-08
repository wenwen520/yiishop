<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 15:58
 */

namespace backend\controllers;


use yii\captcha\CaptchaAction;
use yii\web\Controller;

class CaptchaController extends Controller
{
    //配置生成验证码和校验验证码的方法
    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

}