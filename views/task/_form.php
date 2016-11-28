<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($orders, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($orders, 'nomenklatura')->textInput() ?>
    <?= $form->field($orders, 'tir') ?>
    <?= $form->field($orders, 'progon') ?>
    <?= $form->field($orders, 'timerab') ?>
    <?= $form->field($orders, 'sost')->textInput() ?>
    <?= $form->field($orders, 'comments')->textInput() ?>
    
  

    <div class="form-group">
        <?= Html::submitButton($orders->isNewRecord ? 'Create' : 'Изменить', ['class' => $orders->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 