<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PromoCode;
use frontend\models\PromoZone;
use frontend\models\PromoSearchCode;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PromoCodeController implements the CRUD actions for PromoCode model.
 */
class PromoCodeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PromoCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromoSearchCode();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PromoCode model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PromoCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $promoCodeModel = new PromoCode();
        $promoZoneModel = new PromoZone();
        
        $transaction = Yii::$app->db->beginTransaction();

        $isSuccess = false;
        $areLoaded = $promoCodeModel->load(Yii::$app->request->post()) && $promoZoneModel->load(Yii::$app->request->post());
        if (($areLoaded && $promoCodeModel->save()) === true) {
            if (is_array($promoZoneModel->city_id) === true) {
                $cities = $promoZoneModel->city_id;
                foreach ($cities as $city) {
                    $promoZoneModel = new PromoZone();
                    $promoZoneModel->promo_id = $promoCodeModel->id;
                    $promoZoneModel->city_id = $city;
                    $promoZoneModel->save();
                }
            }
            else {
                $promoZoneModel->promo_id = $promoCodeModel->id;
                $promoZoneModel->save();
            }


            if ($promoZoneModel->save() === true) {
                $areSaved = true;
            }
        } 
        $isSuccess = $areLoaded && $areSaved;

        if ($isSuccess === true) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $promoCodeModel->id]);
        }
        else {
            $transaction->rollBack();
            return $this->render('create', [
                'promoCodeModel' => $promoCodeModel,
                'promoZoneModel' => $promoZoneModel,
            ]);
        }

        /* if ($promoCodeModel->load(Yii::$app->request->post()) && $promoCodeModel->save()) {
            return $this->redirect(['view', 'id' => $promoCodeModel->id]);
        } else {
            return $this->render('create', [
                'promoCodeModel' => $promoCodeModel,
                'promoZoneModel' => $promoZoneModel,
            ]);
        } */
    }

    /**
     * Updates an existing PromoCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        } */



        $promoCodeModel = $this->findModel($id);
        // $promoZonesModel = $promoCodeModel->getZones();
        $promoZoneModels = $promoCodeModel->zones;
        $promoZoneModel = new PromoZone();
        $promoZoneModel->promo_id = $id;

        $citiesArray = array();
        foreach ($promoZoneModels as $model) {
           $citiesArray[] = $model->city_id;
        }
        $promoZoneModel->city_id = $citiesArray;
        
        $transaction = Yii::$app->db->beginTransaction();

        $isSuccess = false;
        $areLoaded = $promoCodeModel->load(Yii::$app->request->post()) && $promoZoneModel->load(Yii::$app->request->post());
        if (($areLoaded && $promoCodeModel->save()) === true) {
            // $promoZoneModels->delete();
            PromoZone::deleteAll(['promo_id' => $id]);
            if (is_array($promoZoneModel->city_id) === true) {
                $cities = $promoZoneModel->city_id;
                foreach ($cities as $city) {
                    $promoZoneModel = new PromoZone();
                    $promoZoneModel->promo_id = $promoCodeModel->id;
                    $promoZoneModel->city_id = $city;
                    $promoZoneModel->save();
                }
            }
            else {
                $promoZoneModel->promo_id = $promoCodeModel->id;
                $promoZoneModel->save();
            }


            if ($promoZoneModel->save() === true) {
                $areSaved = true;
            }
        } 
        $isSuccess = $areLoaded && $areSaved;

        if ($isSuccess === true) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $promoCodeModel->id]);
        }
        else {
            $transaction->rollBack();
            return $this->render('update', [
                'promoCodeModel' => $promoCodeModel,
                'promoZoneModel' => $promoZoneModel,
            ]);
        }
    }

    /**
     * Deletes an existing PromoCode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PromoCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PromoCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromoCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
