<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m171107_063725_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey()->unsigned(),
            'username'=>$this->string(50)->unique()->notNull()->defaultValue("")->comment("用户名"),
            'password'=>$this->char(32)->notNull()->defaultValue(0)->comment("密码"),
            'salt'=>$this->char(6)->comment("盐"),
            'email'=>$this->char(30)->unique()->comment("邮箱"),
            'token'=>$this->char(32)->comment("自动登录令牌"),
            'token_create_time'=>$this->integer(10)->comment("令牌创建时间"),
            'add_time'=>$this->integer(11)->notNull()->defaultValue(0)->comment("注册时间"),
            'last_login_time'=>$this->integer(11)->notNull()->defaultValue(0)->comment("最后登录时间"),
            'last_login_ip'=>$this->char(15)->comment("最后登录IP")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
