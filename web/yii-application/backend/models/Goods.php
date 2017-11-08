<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public static $status=['0'=>'隐藏','1'=>'显示','-1'=>'删除'];
    public static $is_on_sale=['0'=>'不上架','1'=>'上架'];
    public $content;
    public $path;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [[ 'goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort','sn'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 150],
            [['content','path'],'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品货号',
            'logo' => '商品图片',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌ID',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '商品状态',
            'sort' => '商品排序',
            //'inputtime' => '录入时间',
            'content'=>'商品描述',
            'path'=>'商品相册',
        ];
    }

    //注入系统内置时间
    public function behaviors(){
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['inputtime']
                ]
            ]
        ];
    }

    //判断图片地址
    public function getNameText()
    {
        if(substr($this->logo,0,7)=='http://'){
            return $this->logo;
        }else{
            return "@web/".$this->logo;
        }
    }


    //一对多  商品分类
    public function getGoodsCategory(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    //一对一 商品品牌
    public function getBrands(){
        return $this->hasOne(Brands::className(),['id'=>'brand_id']);
    }

    //一对一 商品详情
    public function getGoodsIntro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }

    //一对一 商品相册
    public function getGoodsGallery(){
        return $this->hasOne(GoodsGallery::className(),['id'=>'goods_category_id']);
    }

    //一对一 商品数
    public function getGoodsDayCount(){
        return $this->hasOne(GoodsDayCount::className(),['day'=>'sn ']);
    }
}
