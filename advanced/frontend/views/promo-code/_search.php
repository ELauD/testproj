<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PromoSearchCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-code-search">
<div class = "row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-3 col-sm-3">
        <?= $form->field($model, 'title') ?>
    </div>

    <div class="col-md-3 col-sm-3">
        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
    </div>
    
    <div class="col-md-3 col-sm-3">
        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
    </div>

    <div class="col-md-3 col-sm-3">
        <?= $form->field($model, 'reward') ?>
    </div>

    <?php // echo $form->field($model, 'zone_id') ?>

    <div class="col-md-3 col-sm-3">
        <?= $form->field($model, 'status') ?>
    </div>

    <div class="form-group col-md-12 col-sm-12">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Очистить', ['class' => 'btn btn-default', 'id' => 'reset']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
<br><br><br>
