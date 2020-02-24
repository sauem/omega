<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_name".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $desc
 * @property int|null $status
 *
 * @property DataInput[] $dataInputs
 */
class DataName extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['desc'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'desc' => 'Desc',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[DataInputs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataInputs()
    {
        return $this->hasMany(DataInput::className(), ['name_ID' => 'id']);
    }
}
