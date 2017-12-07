<?php

use frontend\models\City;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $promoCodeModel app\models\PromoCode */
/* @var $promoZoneModel app\models\PromoZone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-code-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($promoCodeModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($promoCodeModel, 'start_date')->widget(DatePicker::classname(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
    
    //= $form->field($promoCodeModel, 'start_date')->textInput() ?>

    <?= $form->field($promoCodeModel, 'end_date')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
    
    
    //$form->field($promoCodeModel, 'end_date')->textInput() ?>

    <?= $form->field($promoCodeModel, 'reward')->textInput(['maxlength' => true]) ?>

    <?= $form->field($promoZoneModel, 'city_id')->dropDownList(ArrayHelper::map(City::find()->orderBy('title')->all(), 'id', 'title'), ['multiple'=>'multiple']) ?>

    <?php 
        if ($promoCodeModel->isNewRecord === false) {
            echo $form->field($promoCodeModel, 'status')->dropDownList([true => 'Активен', false => 'Не активен']);
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton($promoCodeModel->isNewRecord ? 'Create' : 'Update', ['class' => $promoCodeModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
