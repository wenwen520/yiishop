<?php
namespace backend\controllers;

use backend\models\Article_category;
use yii\data\Pagination;
use yii\web\Controller;

class Article_categoryController extends  Controller{
    //显示列表

    public function actionIndex(){
        $query = Article_category::find()->where(['>','status','-1'])->orderBy('sort');

        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>2,

        ]);

        $article_categores=$query->offset($page->offset)->limit($page->limit)->all();



        return $this->render('index',['article_categores'=>$article_categores,'page'=>$page]);
    }

    //添加
    public function actionAdd(){
        $model = new Article_category();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加分类成功');
                return $this->redirect(['article_category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }



    //修改
    public function actionEdit($id){
       $model = Article_category::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','修改分类成功');
                return $this->redirect(['article_category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //删除
    public function actionDelete($id){
        //根据id查到要删除的数据 把他的状态改为1  然后保存
       $category= Article_category::findOne(['id'=>$id]);
        $category->status = -1;
        \Yii::$app->session->setFlash('danger','删除分类成功');
        $category->save();
        return $this->redirect(['article_category/index']);

    }
}