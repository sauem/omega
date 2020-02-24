<?php


namespace common\models;


use Yii;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function beforeSave($insert)
    {
        if ($insert) {
            if(empty($this->created_at))
                $this->created_at = time();
        }
        if(empty($this->updated_at))
            $this->updated_at = time();


        return parent::beforeSave($insert);
    }
    public function load($data, $formName = null)
    {
        $scope = $formName === null ? $this->formName() : $formName;
        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);
            Yii::info ('set attributes '. print_r($data, 1));
            return true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);

            Yii::info ('set attributes scope '.$scope.'=>'. print_r($data, 1));
            return true;
        }
        Yii::info('my scope:'.$scope.', return false');
        return false;
    }
}