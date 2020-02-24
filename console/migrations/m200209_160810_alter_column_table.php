<?php

use yii\db\Migration;

/**
 * Class m200209_160810_alter_column_table
 */
class m200209_160810_alter_column_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("data_input", "ifa"  , $this->text()->null());
        $this->alterColumn("data_input", "android_id"  , $this->text()->null());
        $this->alterColumn("data_input", "user_id"  , $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_160810_alter_column_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_160810_alter_column_table cannot be reverted.\n";

        return false;
    }
    */
}
