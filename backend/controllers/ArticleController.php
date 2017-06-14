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
    public function actionAdd()
    {
        //实例化模型
        $model = new Article();
        $detail = new Article_detail();
        //实例化组件
        $request=\Yii::$app->request;

        //判断传输方式
        if($request->isPost){
            //同时加载文章和详情的数据
           if( $model->load($request->post()) && $detail->load($request->post())){
               //同时验证文章和详情
               if($model->validate() && $detail->validate()){
                   $model->create_time=time();


                    $model->save();
                   $detail->article_id = $model->id;
//
                      //保存详情表
                      $detail->save();
                      //保存成功跳转
                      \Yii::$app->session->setFlash('success','添加文章成功');
                      return $this->redirect(['article/index']);

               }else{
                   var_dump($model->getErrors());
                   var_dump($detail->getErrors());
                   exit;
               }

           }
        }
        //调用添加视图 分配文章模型和详情模型
        return $this->render('add',['model'=>$model,'detail'=>$detail]);

    }

    //修改
    public function actionEdit($id){
       $model = Article::findOne(['id'=>$id]);
        $detail =Article_detail::findOne(['article_id'=>$id]);

        $request=\Yii::$app->request;
        if($request->isPost){
            if($model->load($request->post()) && $detail->load($request->post())){
                if($model->validate() && $detail->validate()){
                    $model->save();
                    $detail->save();
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['article/index']);


            }

            }
        }
        return $this->render('add',['model'=>$model,'detail'=>$detail]);

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