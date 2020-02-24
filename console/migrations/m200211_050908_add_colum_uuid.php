<?php

use yii\db\Migration;

/**
 * Class m200211_050908_add_colum_uuid
 */
class m200211_050908_add_colum_uuid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("data_input" , 'uuid', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200211_050908_add_colum_uuid cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200211_050908_add_colum_uuid cannot be reverted.\n";

        return false;
    }
    */
}
