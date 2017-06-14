<?php
namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionIndex()
    {
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
//                var_dump($admin);exit;
                $admin->login_time = time();

                $admin->save();
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['login'=>$login]);
    }



}