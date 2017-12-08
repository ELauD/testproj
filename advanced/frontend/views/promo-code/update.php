<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $promoCodeModel app\models\PromoCode */
/* @var $promoZoneModel app\models\PromoZone */

$this->title = 'Update Promo Code: ' . $promoCodeModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Promo Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $promoCodeModel->title, 'url' => ['view', 'id' => $promoCodeModel->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promo-code-update">

    <?= $this->render('_form', [
        'promoCodeModel' => $promoCodeModel,
        'promoZoneModel' => $promoZoneModel,
    ]) ?>

</div>
