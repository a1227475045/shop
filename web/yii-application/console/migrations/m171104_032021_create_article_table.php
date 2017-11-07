<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171104_032021_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->defaultValue("")->comment("文章名称"),
            'article_category_id'=>$this->integer(3)->notNull()->defaultValue(1)->comment("文章内容"),
            'intro'=>$this->string(255)->defaultValue("")->comment("文章简介"),
            'status'=>$this->integer(1)->notNull()->defaultValue(1)->comment("文章状态"),
            'sort'=>$this->integer(3)->notNull()->defaultValue(100)->comment("文章排序"),
            'create_time'=>$this->integer(10)->notNull()->comment("文章生日")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
