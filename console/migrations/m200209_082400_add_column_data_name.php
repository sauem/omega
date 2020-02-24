<?php

use yii\db\Migration;

/**
 * Class m200209_082400_add_column_data_name
 */
class m200209_082400_add_column_data_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("data_name","desc", $this->text()->null());
        $this->addColumn("data_name","status", $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_082400_add_column_data_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_082400_add_column_data_name cannot be reverted.\n";

        return false;
    }
    */
}
