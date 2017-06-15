<?php
namespace backend\controllers;

//use backend\models\Album;
use backend\models\Gallery;
use backend\models\Goods;
use backend\models\Goods_category;
use backend\models\Goods_day_count;
use backend\models\Goods_intro;

use backend\models\GoodsSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use xj\uploadify\UploadAction;
use yii\web\NotFoundHttpException;

class GoodsController extends  Controller{
    public function actionIndex(){
//            var_dump($_GET['key']);exit;

            $query=Goods::find();
            if($name = \Yii::$app->request->get('name')){
                $query->andWhere(['like','name',$name]);
            }
            if($sn = \Yii::$app->request->get('sn')){
                $query->andWhere(['like','sn',$sn]);
            }

//        $key=isset($_GET['key'])?$_GET['key']:'';
//        $query=Goods::find()->where(['>','status',0])->andWhere(['like','name',$key]);



        $page=new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>3,
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);

    }
        //添加商品
    public function actionAdd(){
        $model = new Goods();
        $intro=new Goods_intro();
        $goods_day_count =new Goods_day_count();
        $goods_category = new Goods_category();



        $request = \Yii::$app->request;
        if($request->isPost){
            if($model->load($request->post()) && $intro->load($request->post())){
                if($model->validate() && $intro->validate()){

                    $model->create_time = time();
                    $day = date('Ymd');
                    //查询数量表的每日添加数
                    //如果查出来是0  就从1开始计算 如果不是  就从count的数量  +1算
                    if(Goods_day_count:: findOne(['day'=>$day])==null){
                        $goods_day_count->day = $day;
                        $goods_day_count->count =1;
                        $goods_day_count->save();

                    }else{
                        $goods_day_count = Goods_day_count:: findOne(['day'=>$day]);
                        $goods_day_count->count +=1;
                        $goods_day_count->save();
                    }
//                    str_pad()
                    $count=Goods_day_count:: findOne(['day'=>$day])->count;
                    $model->sn = $day.str_pad($count,6,'0',STR_PAD_LEFT); //在添加数的前面补零  STR_PAD_LEFT

                    $model->save(false);
                    //把商品的id赋值给商品详情
                    $intro->goods_id = $model->id;
                    var_dump($model->id);
                    $intro->save(false);



                    \Yii::$app->session->setFlash('success','添加商品详情成功');
                    return $this->redirect(['goods/index']);
                }else{
                    var_dump($model->getErrors());
                    var_dump($intro->getErrors());
                }
            }else{
                var_dump($model->getErrors());
                var_dump($intro->getErrors());
            }
        }
        //获取所有分类选项
        $categories =ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]], Goods_category::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'intro'=>$intro,'categories'=>$categories]);

    }

    //修改商品
    public function actionEdit($id){

        $model = Goods::findOne(['id'=>$id]);
        $intro=Goods_intro::findOne(['goods_id'=>$id]);

        $request = \Yii::$app->request;
        if($request->isPost){
            if($model->load($request->post()) && $intro->load($request->post())){

                if($model->validate() && $intro->validate()){
//                    var_dump($model->logo);exit;

                    $model->save(false);
                    $intro->save(false);
                    \Yii::$app->session->setFlash('success','修改商品详情成功');
                    return $this->redirect(['goods/index']);
                }else{
                    var_dump($model->getErrors());
                    var_dump($intro->getErrors());
                }
            }else{
                var_dump($model->getErrors());
                var_dump($intro->getErrors());
           }
        }
        return $this->render('add',['model'=>$model,'intro'=>$intro]);

    }
        //删除商品
    public function actionDelete($id){
        //逻辑删除
            $goods = Goods::findOne(['id'=>$id]);
//                var_dump($goods);exit;

             $goods->status = '0';
            $goods->save(false);
            \Yii::$app->session->setFlash('success','删除商品成功');
        return $this->redirect(['goods/index']);

    }

    //查看商品详情
    public function actionIntro($id){
        $intro = Goods_intro::findOne(['goods_id'=>$id]);
        return $this->render('intro',['intro'=>$intro]);

    }

    //商品相册
    public function actionGallery($id){
        $goods = Goods::findOne(['id'=>$id]);
        if($goods==null){
            throw new NotFoundHttpException('商品不存在');
        }
        return $this->render('gallery',['goods'=>$goods]);
    }


    /*
     * AJAX删除图片
     */
    public function actionDelGallery(){
        $id = \Yii::$app->request->post('id');
        $model = Gallery::findOne(['id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'fail';
        }

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
                        //图片上传成功的同时 将图片和商品关联起来
                        $model = new Gallery();
                        $model->goods_id = \Yii::$app->request->post('goods_id');
                        $model ->photo = $action->getWebUrl();
                        $model->save();
                        $action->output['fileUrl']= $model->photo;

//                    $imgUrl=$action->getWebUrl();
//
//                    $action->output['fileUrl'] = $action->getWebUrl();
//
//                    //调用七牛云 将上传的图片保存到七牛云
//                    $qiniu = \Yii::$app->qiniu;
//
//                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
//                    //获取图片在七牛云的地址
//                    $qiniu->getLink($imgUrl);


//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }

//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }
////
////    /**
////     * Lists all Goods models.
////     * @return mixed
////     */
//    public function actionIndex()
//    {
//        $searchModel = new GoodsSearch();
//        $models=Goods::find();
//        $goods=Goods::find();
//        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//        return $this->render('index1', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//
//
//
//    }

//        //商品相册
//    public function actionAlbum($id){
//        //上传的时候把图片 根据商品id 全部保存到相册
//
//        $albums = Album::findAll(['goods_id'=>$id]);
////        var_dump($album);exit;
//        return $this->render('album',['albums'=>$albums]);
//
//
//    }


}