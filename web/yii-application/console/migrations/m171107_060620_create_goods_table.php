<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171107_060620_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->defaultValue("")->comment("商品名称"),
            'sn'=>$this->smallInteger(15)->notNull()->comment("商品货号"),
            'logo'=>$this->string(150)->comment("商品图片"),
            'goods_category_id'=>$this->integer(3)->comment("分类ID"),
            'brand_id'=>$this->smallInteger(5)->notNull()->defaultValue(0)->comment("品牌ID"),
            'market_price'=>$this->decimal(10,2)->notNull()->defaultValue(0)->comment("市场价格"),
            'shop_price'=>$this->decimal(10,2)->notNull()->defaultValue(0)->comment("本店价格"),
            'stock'=>$this->integer(11)->notNull()->defaultValue(0)->comment("库存"),
            'is_on_sale'=>$this->integer(4)->notNull()->defaultValue(1)->comment("是否上架 1>是 0>否"),
            'status'=>$this->integer(4)->notNull()->defaultValue(1)->comment("商品状态 1>正常 0>回收站"),
            'sort'=>$this->integer(4)->notNull()->defaultValue(20)->comment("商品排序"),
            'inputtime'=>$this->integer(10)->notNull()->defaultValue(0)->comment("录入时间")

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
