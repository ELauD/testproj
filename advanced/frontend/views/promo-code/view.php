<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\PromoCode */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Promo Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-code-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? if ($model->status == true) 
            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) 
        ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'start_date',
            'end_date',
            'reward',
            [
                'label' => 'Тарифная зона', 
                'format' => 'raw',
                'value' => implode('<br> ', ArrayHelper::map($model->cities, 'id', 'title'))
            ],
            ['attribute' => 'status', 'value'=> (($model->status == true)?'Активен':'Не активен')],
        ],
    ]) ?>

</div>
