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

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['title', 'start_date', 'end_date', 'reward'],
            self::SCENARIO_UPDATE => ['title', 'start_date', 'end_date', 'reward', 'status'],
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'start_date', 'end_date', 'reward'], 'required'],
            [['status'], 'required', 'on' => 'update'],
            [['title'], 'unique'],
            [['title'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
            [['start_date','end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_date'],'validateDates'],
            [['reward'], 'match', 'pattern'=>'/^[0-9]{1,19}(\.[0-9]{0,4})?$/'],
            [['reward'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'double'],
            [['status'], 'boolean'],
        ];
    }

    public function validateDates()
    {
        if(strtotime($this->end_date) <= strtotime($this->start_date)){
            $this->addError('start_date','Дата начала не должна быть позже даты окончания или совпадать с ней');
        }
    }
    
    public function fields()
    {
        $fields = parent::fields();

        $fields += [
            'zone' => function ($model) {
                return $model->cities;
            },
        ];

        return $fields;
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
