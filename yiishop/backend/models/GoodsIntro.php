<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/7
 * Time: 17:52
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsIntro extends ActiveRecord
{
    public static function tableName(){
        return 'goods_intro';
    }

    public function rules(){
        return [
          [['content'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'content' => '商品详情'
        ];
}
}