<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/7
 * Time: 22:30
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsDayCount extends ActiveRecord
{
    public function rules(){
        return [
            [['count'],'integer']
        ];
    }
    public function attributeLabels()
    {
        return [
            'day' => '商品货号',
            'count' => '商品数量'
        ];
    }

    public static function tableName(){
        return 'goods_day_count';
    }
}