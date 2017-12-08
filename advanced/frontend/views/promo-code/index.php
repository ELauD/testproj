<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PromoSearchCode */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promo Codes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-code-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Promo Code', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model){
                    return Html::a($model->title, ['view', 'id' => $model->id], ['target' => '_blank']);
                },
            ],
            'start_date',
            'end_date',
            'reward',
            // 'zone_id',
            [
                'label' => 'Тарифная зона', 
                'format' => 'raw',
                'value' => function ($model){
                    return implode('<br>', ArrayHelper::map($model->cities, 'id', 'title'));
                },
            ],
            [
                'attribute' => 'status', 
                'value' => function ($model) {
                    if ($model->status == true) {
                        return 'Активен';
                    } else {
                        return 'Не активен';
                    }
                }   
            ],

            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if ($model->status == true)
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Редактировать'),
                                        //'class'=>'btn btn-primary btn-xs',                                  
                            ]) ;
                    },
                ],
            ],

        ],
    ]); ?>
</div>
