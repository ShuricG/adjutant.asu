<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sost;
use yii\helpers\ArrayHelper;

$this->title = 'Заказ №: ' . $orders->num;
/*$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $orders->title, 'url' => ['view', 'id' => $orders->id]];
$this->params['breadcrumbs'][] = 'Edit';*/
?>

<div class="order-update">
    <h3><?= Html::encode($this->title) ?></h3>

	<div class="order-form">

	   <?php $form = ActiveForm::begin(); ?>
	    <?= $form->field($orders, 'title') ?>
	    <?= $form->field($orders, 'tirag') ?>
	    <?= $form->field($orders, 'ending')->textInput(['class' => 'tcal'])?>
	    <?= $form->field($orders, 'srok') ?>
	    <?= $form->field($orders, 'dop_info')->textarea(['rows' => 3])?>
	 
	    <div class="form-group">
	        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
	        <?= Html::a('Список заказов', ['order/index'], ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>
</div>
