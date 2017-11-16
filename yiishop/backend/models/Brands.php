<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "brands".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property string $content
 * @property integer $create_time
 */
class Brands extends \yii\db\ActiveRecord
{
   // public $imgfile;
    public static $statustext=['-1'=>"删除",'0'=>"隐藏",'1'=>"上线"];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','sort'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['logo'], 'string', 'max' => 100],
            [[ 'content'], 'string', 'max' => 255],
           // [['imgfile'],'file','extensions'=>['gif','jpg','png'],'skipOnEmpty'=>true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'logo' => '品牌logo',
            'content' => '品牌简介',
           // 'create_time' => '品牌添加时间',
            'status'=>'品牌状态',
            'logo'=>'品牌LOGO',
            'sort'=>'品牌排序',
        ];
    }

    //注入系统内置时间
    public function behaviors(){
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['create_time']
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


    public function getGoods(){
        return $this->hasOne(Goods::className(),['brand_id'=>'id']);
    }
}
