<?php
namespace backend\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Goods extends  ActiveRecord
{
    public static $status = ['1' => '正常', '0' => '回收站'];
    public static $is_on_sale = ['1' => '在售', '0' => '下架'];

    //关联相册表
    public function getGalleries(){
        return $this->hasMany(Gallery::className(),['goods_id'=>'id']);
    }

    //关联商品每日添加数量表
    public function getGoods_day_count()
    {
        return $this->hasOne(Goods_day_count::className(), ['day' => 'create_time']);
    }

    //关联品牌
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    //关联分类
    public function getGoods_category()
    {
        return $this->hasOne(Goods_category::className(), ['id' => 'goods_category_id']);
    }

    //关联商品详情表
    public function getGoods_intro()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    public function rules()
    {
        return [
            [['name', 'goods_category_id', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status', 'sort'], 'required'],
            [['sort', 'logo'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'logo' => 'LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
        ];
    }


}