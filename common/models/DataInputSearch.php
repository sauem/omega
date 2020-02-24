<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DataInput;

/**
 * DataInputSearch represents the model behind the search form of `common\models\DataInput`.
 */
class DataInputSearch extends DataInput
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name_ID', 'attr_touch_time', 'install_time', 'event_time', 'campaign_id', 'created_at', 'updated_at'], 'integer'],
            [['attr', 'event_name', 'event_value', 'event_revenue', 'event_revenue_currency', 'event_revenue_vnd', 'partner', 'media_source', 'campaign', 'site_id', 'sub_site_id', 'sub_param_1', 'sub_param_2', 'sub_param_3', 'sub_param_4', 'sub_param_5', 'ip', 'appsflyer_id', 'adv_id', 'ifa', 'android_id', 'user_id', 'platform', 'device_type', 'app_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params , $parent)
    {
        $query = DataInput::find()->where(['name_ID' => $parent]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'name_ID' => $this->name_ID,
            'attr_touch_time' => $this->attr_touch_time,
            'install_time' => $this->install_time,
            'event_time' => $this->event_time,
            'campaign_id' => $this->campaign_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'attr', $this->attr])
            ->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'event_value', $this->event_value])
            ->andFilterWhere(['like', 'event_revenue', $this->event_revenue])
            ->andFilterWhere(['like', 'event_revenue_currency', $this->event_revenue_currency])
            ->andFilterWhere(['like', 'event_revenue_vnd', $this->event_revenue_vnd])
            ->andFilterWhere(['like', 'partner', $this->partner])
            ->andFilterWhere(['like', 'media_source', $this->media_source])
            ->andFilterWhere(['like', 'campaign', $this->campaign])
            ->andFilterWhere(['like', 'site_id', $this->site_id])
            ->andFilterWhere(['like', 'sub_site_id', $this->sub_site_id])
            ->andFilterWhere(['like', 'sub_param_1', $this->sub_param_1])
            ->andFilterWhere(['like', 'sub_param_2', $this->sub_param_2])
            ->andFilterWhere(['like', 'sub_param_3', $this->sub_param_3])
            ->andFilterWhere(['like', 'sub_param_4', $this->sub_param_4])
            ->andFilterWhere(['like', 'sub_param_5', $this->sub_param_5])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'appsflyer_id', $this->appsflyer_id])
            ->andFilterWhere(['like', 'adv_id', $this->adv_id])
            ->andFilterWhere(['like', 'ifa', $this->ifa])
            ->andFilterWhere(['like', 'android_id', $this->android_id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'app_name', $this->app_name]);

        return $dataProvider;
    }
}
