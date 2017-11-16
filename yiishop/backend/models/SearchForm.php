<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/8
 * Time: 22:10
 */

namespace backend\models;


use yii\base\Model;

class SearchForm extends Model
{
    public $keyword;
    public $minPrice;
    public $maxPrice;

    public function rules(){
        return [
          [['minPrice','maxPrice'],'number','message'=>''],
            [['keyword'],'safe']
        ];
    }
}