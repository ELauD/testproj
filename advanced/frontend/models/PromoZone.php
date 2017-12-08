<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "promo_zone".
 *
 * @property integer $id
 * @property integer $promo_id
 * @property integer $city_id
 *
 * @property PromoCode[] $promoCode
 * @property City $city
 */
class PromoZone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_zone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promo_id', 'city_id'], 'required'],
            [['promo_id', 'city_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['promo_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromoCode::className(), 'targetAttribute' => ['promo_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promo_id' => 'Promo ID',
            'city_id' => 'Тарифная зона',
        ];
    }

    /* public function save($promo_id)
    {
        if (is_array($this->city_id)) {
            $cities = $this->city_id;
            foreach ($cities as $city) {
                $this->city_id = $city;
                $this->promo_id = $promo_id;
            }
        }
        else {
            $this->city_id = $city;
            $this->promo_id = $promo_id;
        }
    } */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromoCode()
    {
        return $this->hasOne(PromoCode::className(), ['id' => 'promo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
