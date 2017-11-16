<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/7
 * Time: 17:54
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsGallery extends ActiveRecord
{
    public $imgFile;


    public static function tableName(){
        return 'goods_gallery';
    }


    public function rules(){
        return [
            [['path'],'required'],
          [['path','imgFile'],'safe']

        ];
    }
    public function attributeLabels()
    {
        return [
            'imgFile' => '商品相册',
            'path'=>'商品图片'
        ];
    }
}