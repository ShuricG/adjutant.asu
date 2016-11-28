<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sost;
use yii\helpers\ArrayHelper;

$this->title = 'Заказ №: ' . $orders->name;
/*$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $orders->title, 'url' => ['view', 'id' => $orders->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>

<div class="order-update">
    <h3><?= Html::encode($this->title) ?></h3>

	<div class="order-form">

	   <?php $form = ActiveForm::begin([
/*        'options' => ['class' => 'form-horizontal'],
        	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n",
            'labelOptions' => ['class' => 'col-lg-5 control-label'],
	        ],*/
	    ]); ?>
	    <?= $form->field($orders, 'nomenklatura') ?>
	    <?= $form->field($orders, 'progon') ?>
	    <?= $form->field($orders, 'start') ?>
	    <?= $form->field($orders, 'end') ?>
	    <?= $form->field($orders, 'timerab') ?>
	    <?= $form->field($orders, 'nrec') ?>
		<?php
			$sost = Sost::find()->all();
		    $items = ArrayHelper::map($sost,'id_sost','description');
/*		    $params = ['prompt' => 'Укажите статус'];*/
		    echo $form->field($orders, 'sost')->dropDownList($items);
		?>	    
	    <?= $form->field($orders, 'comments')->textarea(['rows' => 3])?>
	 
	    <div class="form-group">
	        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
		    <?= Html::a('Удалить', ['task/delete', 'id' => $orders['id']], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => 'Вы уверены, что хотите удалить это задание?',
	                'method' => 'post',
	            ],
	        ]) ?>
	        <?= Html::a('Закрыть', ['task/index'], ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>
</div>
