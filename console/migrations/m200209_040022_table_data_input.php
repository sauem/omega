<?php

use yii\db\Migration;

/**
 * Class m200209_040022_table_data_input
 */
class m200209_040022_table_data_input extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%data_input}}', [
            'id' => $this->primaryKey(),
            'name_ID' => $this->integer(),
            'attr' => $this->string(255)->defaultValue('click'),
            'attr_touch_time' => $this->integer(),
            'install_time' => $this->integer(),
            'event_time' => $this->integer(),
            'event_name' => $this->string(255)->notNull(),
            'event_value' => $this->text()->null(),
            'event_revenue' => $this->string()->null(),
            'event_revenue_currency' => $this->string(255)->defaultValue('USD'),
            'event_revenue_vnd' => $this->text()->null(),
            'partner' => $this->string(255)->notNull(),
            'media_source' => $this->string(255)->notNull(),
            'campaign' => $this->string(255)->notNull(),
            'campaign_id' => $this->integer()->null(),
            'site_id' => $this->text(),
            'sub_site_id' => $this->text()->null(),
            'sub_param_1' => $this->text()->null(),
            'sub_param_2' => $this->text()->null(),
            'sub_param_3' => $this->text()->null(),
            'sub_param_4' => $this->text()->null(),
            'sub_param_5' => $this->text()->null(),
            'ip' => $this->string(255)->null(),
            'appsflyer_id' => $this->string(255)->null(),
            'adv_id' => $this->string(255)->null(),
            'ifa' => $this->integer()->null(),
            'android_id' => $this->integer()->null(),
            'user_id' => $this->integer()->null(),
            'platform' => $this->string(255)->defaultValue('android'),
            'device_type' => $this->string(255)->null(),
            'app_name' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey("fk_dataname-input",'data_input','name_id','data_name','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_040022_table_data_input cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_040022_table_data_input cannot be reverted.\n";

        return false;
    }
    */
}
