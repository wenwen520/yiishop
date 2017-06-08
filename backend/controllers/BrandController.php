<?php
namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller{
    //显示列表
    public function actionIndex(){

        //获取所有状态大于-1的数据  并按序号升序排列
        $query = Brand::find()->where(['>','status','-1'])->orderBy('sort');
        //获取总条数
        $total=$query->count();

        //实例化分页类
        $page = new Pagination([
            //设置每页显示条数和总条数
            'totalCount'=>$total,
            'defaultPageSize'=>1,
        ]);

        //设置limit和偏移量
        $brands=$query->offset($page->offset)->limit($page->limit)->all();

            //->where(['>','status','-1'])->orderBy('sort')->all();
        //分配到视图
        return $this->render('index',['brands'=>$brands,'page'=>$page]);
    }
    //添加
    public function actionAdd(){
        //实例化模型
        $model=new Brand();
//        $model->setScenario('add');
        //实例化组件
        $request=\Yii::$app->request;
        //判断数据传输方式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //实例化文件模型
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据
            if($model->validate()){

                if($model->imgFile){
                    //保存图片地址  赋值给数据库的字段
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }

                //保存数据
                $model->save(false);
                //跳转到列表页
                return $this->redirect(['brand/index']);
            }
        }
        //调用视图 显示添加页面
        return $this->render('add',['model'=>$model]);

    }

    //删除
    public function actionDelete($id){


       //查出要删除的这条id的信息 修改为-1  在列表中删除此数据  数据库不删除
        $model = Brand::findOne(['id'=>$id]);

//        var_dump($model);
        $model->status=-1;
       // var_dump($model->status);exit;
        //删除成功提示信息并跳转到列表页
        $res = $model->save(false);

        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['brand/index']);
    }

    //修改
    public function actionEdit($id){
        //根据id找到该条数据
        $model=Brand::findOne($id);
        //创建组件
        $request = \Yii::$app->request;
        //判断传输方式
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //实例化文件对象
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据
            if($model->validate()){
                if($model->imgFile){
                    //保存图片地址
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);

                    $model->logo=$fileName;
                }


                //修改数据
                $model->save(false);
                //跳转到列表页
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }


        }

        //调用试图显示修改页面
        return $this->render('add',['model'=>$model]);
    }



}