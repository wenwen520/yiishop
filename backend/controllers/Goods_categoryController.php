<?php
namespace backend\controllers;

use backend\models\Goods;
use backend\models\Goods_category;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class Goods_categoryController extends Controller{
        //列表
    public function actionIndex(){
        $query = Goods_category::find();
        $total = $query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>2,
        ]);

        $goods = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['goods'=>$goods,'page'=>$page]);
    }

    //添加
    public function actionAdd(){
        $model = new Goods_category();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());

            if($model->validate()){

                //判断是否是一级分类   判断parent_id是否为0
                if($model->parent_id){
                    //添加非一级分类
                    //先查出他的上一级分类
                    $parent = Goods_category::findOne(['id'=>$model->parent_id]);
                    //添加到上一级分类下面
                    $model->prependTo($parent);
                }else{
                    //添加一级分类
                    $model->makeRoot();
                }
                \Yii::$app->session->setFlash('success','添加分类成功');
                return $this->redirect(['goods_category/index']);
            }
        }
        //获取所有分类选项
        $categories =ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]], Goods_category::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }

    //修改
    public function actionEdit($id){
        $model = Goods_category::findOne(['id'=>$id]);
        $parent_id =$model->parent_id;
        //判断是否有这个分类
        if($model==null){
            throw new NotFoundHttpException('分类不存在');
        }

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());

            if($model->validate()){

                //判断是否是一级分类   判断parent_id是否为0
                if($model->parent_id){
                    //添加非一级分类
                    //先查出他的上一级分类
                    $parent = Goods_category::findOne(['id'=>$model->parent_id]);
                    //添加到上一级分类下面
                    $model->prependTo($parent);
                }else{
                    //判断父id是否为0 且没有改变
                    if($model->getOldAttribute('parent_id') ==0 ){
                        $model->save();
                    }else{
                        //添加一级分类
                        $model->makeRoot();
                    }

                }
                \Yii::$app->session->setFlash('success','修改分类成功');
                return $this->redirect(['goods_category/index']);
            }
        }
        //获取所有分类选项
        $categories =ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]], Goods_category::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }
    //删除
    public function actionDelete($id){

        //删除的时候根据id找到数据  查询该数据下面有没有子节点  有的话不允许删除

       $category=  Goods_category::findOne(['parent_id'=>$id]);
//        var_dump();exit;
        if(empty($category)){
            Goods_category::findOne($id)->delete();
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['goods_category/index']);
        }else{
            \Yii::$app->session->setFlash('danger','该分类下有子分类不允许删除');
            return $this->redirect(['goods_category/index']);
        }



    }

    //ztree
    public function actionZtree(){
        $categories = Goods_category::find()->asArray()->all();
        return $this->renderPartial('ztree',['categories'=>$categories]);
    }
}