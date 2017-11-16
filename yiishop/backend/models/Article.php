<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $content;
    public static $status=['0'=>'没上线','1'=>'上线'];

    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_category_id', 'status', 'sort','category_id'], 'integer'],
            [['name','sort','intro'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 255],
           [['content'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章编号',
            'name' => '文章名称',
            'article_category_id' => '文章内容',
            'intro' => '文章简介',
            'status' => '文章状态',
            'sort' => '文章排序',
            //'create_time' => '文章生日',
            'content'=>'文章内容',
            'category_id'=>'文章分类'

        ];
    }

    //一对一
    public function getDetail()
    {
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }

    //一对一
    public function getArticleCategory(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'category_id']);
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
}
