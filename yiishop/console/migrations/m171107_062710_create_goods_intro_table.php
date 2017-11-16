<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m171107_062710_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'goods_id' => $this->primaryKey()->comment("商品ID"),
            'content'=>$this->text()->comment("商品内容"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
