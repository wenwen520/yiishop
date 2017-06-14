<?php
namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

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
            'defaultPageSize'=>2,
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
            //var_dump($request->post());exit;
            //加载数据
            $model->load($request->post());
            var_dump($model);

            //验证数据
            if($model->validate()){


                //保存数据
                $model->save(false);
                \Yii::$app->session->setFlash('success','添加成功');
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

            //验证数据
            if($model->validate()){
                //修改数据
                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                //跳转到列表页
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }


        }

        //调用试图显示修改页面
        return $this->render('add',['model'=>$model]);
    }

    //uploadify插件
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {

                    $imgUrl=$action->getWebUrl();

                    $action->output['fileUrl'] = $action->getWebUrl();

                    //调用七牛云 将上传的图片保存到七牛云
                    $qiniu = \Yii::$app->qiniu;

                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
                    //获取图片在七牛云的地址
                    $qiniu->getLink($imgUrl);


//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }



//    //七牛云
//    public function actionQiniu(){
//        $ak = 'sWBj7OeAUrGYTz1s8xEKdPMMHQjRWZYw6_8eWIg5';
//        $sk = 'nBJF3chS_rNmQbroplwS54SkP6S5UCPv5R-2IfeB';
//        $domain = 'http://or9ry3af8.bkt.clouddn.com/';
//        $bucket = 'yiishop';
//
//        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
//        $fileName = \Yii::getAlias('@webroot').'/upload/1.jpg';
//        $key = time();
//        $re = $qiniu->uploadFile($fileName,$key);
//
//
//        $url = $qiniu->getLink($key);
//
//    }
}