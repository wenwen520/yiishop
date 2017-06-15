<?php
namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\PwdForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionIndex()
    {
        //var_dump(\Yii::$app->user);exit;
        $query = Admin::find();
        $total = $query->count();
        $page = new Pagination([
            'totalCount' => $total,
            'defaultPageSize' => 5,
        ]);
        $admins = $query->offset($page->offset)->limit($page->limit)->all();

        return $this->render('index', ['admins' => $admins]);
    }


    public function actionAdd()
    {
        $model = new Admin();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->login_time = 0;
                $model->login_ip = 0;
                $model->save();
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }


    //添加管理员测试帐号
    public function actionA()
    {
        $admin = new Admin();
            $admin->uesrname='admin';
            $admin->password='123456';
        $admin->auth_key = \Yii::$app->security->generateRandomString();
        $admin->save();
                return $this->redirect(['admin/login']);
    }



    public function actionEdit($id)
    {
        $model = Admin::findOne(['id' => $id]);
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('edit', ['model' => $model]);

    }

    public function actionDelete($id){
        Admin::findOne(['id'=>$id])->delete();
        return $this->redirect(['admin/index']);
    }




    //用户登录
    public function actionLogin(){
        //实例化一个登录模型表单
        $login = new LoginForm();
        //加载验证
        $request = \Yii::$app->request;

        if($request->isPost){
           $login->load($request->post());
            if($login->validate()){
                //获取当前登录用户的信息
                $admin = Admin::findOne(['username'=>$login->username]);
                $admin->login_time = time();
                $ip = \Yii::$app->request->userIP;
                $admin->login_ip = $ip;
                $admin->save(false);
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['login'=>$login]);
    }

    //注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['admin/login']);
    }


    //修改密码
    public function actionPwd($id){
        //实例化修改密码的表单
        $model = new PwdForm();
        $admin = Admin::findOne(['id'=>$id]);//得到用户信息
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //旧密码验证通过了 获取用户输入的新密码 加密 保存到数据库
                $newpwd = $model->repassword;
                $repwd = \Yii::$app->security->generatePasswordHash($newpwd);
                $model->password = $repwd;
                \Yii::$app->session->setFlash('success','密码修改成功');
                return $this->redirect(['admin/index']);
            }
        }
            return $this->render('pwd',['model'=>$model]);
    }


    //授权
    public function behaviors(){
        return[
            'access'=>[
                'class'=>AccessControl::className(),
//                'only'=>['add','index','delete','edit','editPwd'],//该过滤器作用的操作  不写就是全部操作
                'rules'=>[//规则
                    [
                        'allow'=>true,//是否允许执行
                        'actions'=>['add','index','delete','edit','login','pwd','logout'],//指定操作
                        'roles'=>['@'], //角色  ？ 未认证用户  @已认证用户
                    ],
                    [//规则
                        'allow'=>true,//是否允许执行
                        'actions'=>['index','login'],//指定操作
                        'roles'=>['?'], //角色  ？ 未认证用户  @已认证用户
                    ]
                ]

            ]
        ];

    }


}