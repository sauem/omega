<?php

use yii\db\Migration;

/**
 * Class m200207_034622_add_column_user
 */
class m200207_034622_add_column_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user",'fullname',$this->string(255)->null());
        $this->addColumn("user",'avatar',$this->text()->null());
        $this->addColumn("user",'user_code',$this->string(255)->notNull());
        $this->addColumn("user",'secret_key',$this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200207_034622_add_column_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200207_034622_add_column_user cannot be reverted.\n";

        return false;
    }
    */
}
