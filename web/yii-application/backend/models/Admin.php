<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $token
 * @property integer $token_create_time
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token_create_time', 'add_time', 'last_login_time'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password', 'token'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 6],
            [['email'], 'string', 'max' => 30],
            [['last_login_ip'], 'string', 'max' => 15],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'salt' => '盐',
            'email' => '邮箱',
            'token' => '自动登录令牌',
            'token_create_time' => '令牌创建时间',
            'add_time' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
        ];
    }
}
