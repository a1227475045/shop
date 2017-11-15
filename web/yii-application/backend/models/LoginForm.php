<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/9
 * Time: 10:42
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
        public $username;
        public $password;

        //记住我  默认true
        public $rememberMe = true;

    //设置验证规则
    public function rules(){
        return [
            [['username','password'],'required'],
            ['rememberMe', 'safe'],
        ];
    }

    //设置中文显示
    public function attributeLabels(){
        return [
            'username'=>'管理员账户',
            'password'=>'管理员密码',
            'rememberMe'=>'记住密码，下次自动登录',
        ];
    }
}