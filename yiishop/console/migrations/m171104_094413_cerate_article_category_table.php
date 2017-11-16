<?php

use yii\db\Migration;

/**
 * Class m171104_094413_cerate_article_category_table
 */
class m171104_094413_cerate_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
    $this->createTable('article_category',[
       'id'=>$this->primaryKey(),
       'name'=>$this->string(30)->notNull()->defaultValue("")->comment("分类名称"),
        'intro'=>$this->string(255)->defaultValue("")->comment("分类简介"),
        'status'=>$this->smallInteger(1)->notNull()->defaultValue(1)->comment("分类状态"),
        'sort'=>$this->smallInteger(3)->notNull()->defaultValue(100)->comment("分类排序"),
        'is_help'=>$this->smallInteger(4)->notNull()->defaultValue(0)->comment("是否需要帮助"),
    ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
