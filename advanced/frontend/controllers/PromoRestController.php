<?php

namespace frontend\controllers;

use frontend\models\PromoCode;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class PromoRestController extends ActiveController
{
    public $modelClass = 'frontend\models\PromoCode';

    public function actionGetDiscountInfo($title) 
    {
        return new ActiveDataProvider([
            'query' => PromoCode::find()->where(['title' => $title]),
        ]);
    }

    public function actionActivateDiscount($title, $city)
    {
        $model = PromoCode::find()
            ->joinWith('cities')
            ->where(['promo_code.title' => $title])
            ->andWhere(['city.title' => $city])
            ->one();

        return $model->reward;
    }
}

?>