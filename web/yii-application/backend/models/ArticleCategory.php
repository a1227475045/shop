<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    public static $statustext=['0'=>'不显示','1'=>'显示'];
    public static $is_helptext=['0'=>'否','1'=>'是'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['status', 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类编号',
            'name' => '分类名称',
            'intro' => '分类简介',
            'status' => '分类状态',
            'sort' => '分类排序',
            'is_help' => '是否需要帮助',
        ];
    }
}
