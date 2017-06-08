<?php
namespace backend\controllers;

use backend\models\Article_detail;
use yii\web\Controller;

class Article_detailController extends Controller{

    //列表
    public function actionIndex(){
        $article_detail = Article_detail::find()->all();
        return $this->render('index',['article_detail'=>$article_detail]);

    }

    //添加
    public function actionAdd(){
        $model = new Article_detail();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['article_detail/index']);
            }

        }
        return $this->render('add',['model'=>$model]);

    }
    //删除
    public function actionDelete($article_id){
        //找到该文章对应的文章id  查到文章表
       Article_detail::findOne(['article_id'=>$article_id])->delete();
        \Yii::$app->session->setFlash('success','文章删除成功');
        return $this->redirect(['article_detail/index']);


    }
    //修改
    public function actionEdit($article_id){
        $model = Article_detail::findOne(['article_id'=>$article_id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                \Yii::$app->session->setFlash('success','文章修改成功');
                return $this->redirect(['article_detail/index']);
            }
        }
        return $this->render('add',['model'=>$model]);

    }

}