<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "promo_code".
 *
 * @property integer $id
 * @property string $title
 * @property string $start_date
 * @property string $end_date
 * @property string $reward
 * @property integer $status
 *
 * @property PromoZone $zones
 */
class PromoCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['title', 'start_date', 'end_date', 'reward', 'zone_id'], 'required'],
            [['title', 'start_date', 'end_date', 'reward'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['reward'], 'number'],
            // [['zone_id', 'status'], 'integer'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            //[['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromoZone::className(), 'targetAttribute' => ['zone_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата окончания',
            'reward' => 'Вознаграждение',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZones()
    {
        return $this->hasMany(PromoZone::className(), ['promo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['id' => 'city_id'])->via('zones');
    }
}
