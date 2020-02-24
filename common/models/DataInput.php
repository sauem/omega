<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "data_input".
 *
 * @property int $id
 * @property int|null $name_ID
 * @property string|null $attr
 * @property int|null $attr_touch_time
 * @property int|null $install_time
 * @property int|null $event_time
 * @property string $event_name
 * @property string|null $event_value
 * @property string|null $event_revenue
 * @property string|null $event_revenue_currency
 * @property string|null $event_revenue_vnd
 * @property string $partner
 * @property string $media_source
 * @property string $campaign
 * @property int|null $campaign_id
 * @property string|null $site_id
 * @property string|null $sub_site_id
 * @property string|null $sub_param_1
 * @property string|null $sub_param_2
 * @property string|null $sub_param_3
 * @property string|null $sub_param_4
 * @property string|null $sub_param_5
 * @property string|null $ip
 * @property string|null $appsflyer_id
 * @property string|null $adv_id
 * @property int|null $ifa
 * @property int|null $android_id
 * @property int|null $user_id
 * @property string|null $platform
 * @property string|null $device_type
 * @property string|null $app_name
 * @property int $created_at
 * @property int $updated_at
 * @property int $uuid
 *
 * @property DataName $name
 */
class DataInput extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ID', 'attr_touch_time', 'install_time', 'event_time', 'campaign_id', 'ifa', 'android_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['event_name', 'partner', 'media_source', 'campaign', 'created_at', 'updated_at'], 'required'],
            [['event_value', 'event_revenue_vnd', 'site_id', 'sub_site_id', 'sub_param_1', 'sub_param_2', 'sub_param_3', 'sub_param_4', 'sub_param_5','uuid'], 'string'],
            [['attr', 'event_name', 'event_revenue', 'event_revenue_currency', 'partner', 'media_source', 'campaign', 'ip', 'appsflyer_id', 'adv_id', 'platform', 'device_type', 'app_name'], 'string', 'max' => 255],
            [['name_ID'], 'exist', 'skipOnError' => true, 'targetClass' => DataName::className(), 'targetAttribute' => ['name_ID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ID' => 'Name ID',
            'attr' => 'Attr',
            'attr_touch_time' => 'Attr Touch Time',
            'install_time' => 'Install Time',
            'event_time' => 'Event Time',
            'event_name' => 'Event Name',
            'event_value' => 'Event Value',
            'event_revenue' => 'Event Revenue',
            'event_revenue_currency' => 'Event Revenue Currency',
            'event_revenue_vnd' => 'Event Revenue Vnd',
            'partner' => 'Partner',
            'media_source' => 'Media Source',
            'campaign' => 'Campaign',
            'campaign_id' => 'Campaign ID',
            'site_id' => 'Site ID',
            'sub_site_id' => 'Sub Site ID',
            'sub_param_1' => 'Sub Param 1',
            'sub_param_2' => 'Sub Param 2',
            'sub_param_3' => 'Sub Param 3',
            'sub_param_4' => 'Sub Param 4',
            'sub_param_5' => 'Sub Param 5',
            'ip' => 'Ip',
            'appsflyer_id' => 'Appsflyer ID',
            'adv_id' => 'Adv ID',
            'ifa' => 'Ifa',
            'android_id' => 'Android ID',
            'user_id' => 'User ID',
            'platform' => 'Platform',
            'device_type' => 'Device Type',
            'app_name' => 'App Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'uuid' => 'UUID',
        ];
    }

    /**
     * Gets query for [[Name]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function beforeSave($insert)
    {
        if($insert){
            $this->attr_touch_time = strtotime($this->attr_touch_time);
            $this->install_time = strtotime($this->install_time);
            $this->event_time = strtotime($this->event_time);
            if(!empty($this->event_value)){
                $uid = json_decode($this->event_value,TRUE);
                $this->uuid = isset($uid['UUID']) ? $uid['UUID'] : '';
            }
        }
        return parent::beforeSave($insert);
    }

    public function getName()
    {
        return $this->hasOne(DataName::className(), ['id' => 'name_ID']);
    }

    public static function getSource($name = 'media_source'){
        $source =  DataInput::find()->groupBy($name)->all();
        return ArrayHelper::map($source,$name,$name);
    }
}
