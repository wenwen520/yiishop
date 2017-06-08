<?php
namespace backend\controllers;

use backend\models\Article;
use backend\models\Article_detail;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller{
    public function actionIndex(){
        $query = Article::find()->where(['>','status','-1']);
        $total = $query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>2,
        ]);

        $articles = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['articles'=>$articles,'page'=>$page]);
    }


    //添加
    public function actionAdd(){
        //实例化模型
        $model = new Article();
        //实例化组件
        $request=\Yii::$app->request;
        //判断传输方式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            if($model->validate()){
                //验证成功
                //保存数据
                $model->create_time=time();
                $model->save();

                //跳转到列表页
                return $this->redirect(['article/index']);
            }
        }

        //调用视图显示添加表单
        return $this->render('add',['model'=>$model]);
    }

    //修改
    public function actionEdit($id){
       $model = Article::findOne(['id'=>$id]);
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model]);

    }
     //删除
    public function actionDelete($id){
       $model = Article::findOne(['id'=>$id]);
        $model->status =-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);

    }

    //查看文章详情
    public function actionDetail($id){
        //找到该文章的详情
       $article= Article_detail::findOne(['article_id'=>$id]);
//        var_dump($article->article->name);exit;
        return $this->render('detail',['article'=>$article]);

    }
}