<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\order */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="order-view">

  	<div class="table-responsive">
	    <table class="table table-hover table-striped">
			<tr>
			    <th>Наименование</th><td><?= $orders['title']?></td>     
			</tr>
			<tr>    
			    <th>Тираж</th><td><?= $orders['tirag']?></td>
			</tr>
			<tr>    
			    <th>Начало печати</th><td><?= getFormat($orders['start_press'])?></td>
			</tr>
			<tr>    
			    <th>Окончание печати</th><td><?= getFormat($orders['end_press'])?></td>
			</tr>
			<tr>    
			    <th>Отделка</th><td><?= $orders['post_press']?></td>
			</tr>		
			<tr>    
			    <th>Дата сдачи</th><td><?= getFormat($orders['ending'])?></td>
			</tr>					
			<tr>    
			    <th>Срок</th><td><?= getFormat($orders['srok'])?></td>
			</tr>
			<tr>    
			    <th>Статус</th><td><?= $orders->sost['title_status']?></td>
			</tr>					
			<tr>    
			    <th>Примечание</th><td><?= $orders['dop_info']?></td>
			</tr>					
	    </table>
	    
	    <table class="table table-hover table-striped">
	        <thead>
	        <tr>
	            <th>Номенклатура</th>
	            <th>Тираж</th>
	            <th>Печатная машина</th>
	            <th>Начало печати</th>
	            <th>Конец печати</th>
	            <th>Листопрогон</th>
	            <th>Время печати</th>
	            <th>Примечание</th>
	        </tr>
	        </thead>
	        <tbody>
	        <?php foreach($task as $item):?>
	            <tr>
	                <td><a href="<?= \yii\helpers\Url::to(['#', 'id' => $item->id])?>"><?= $item['nomenklatura']?></a></td>
	                <td><?= $item['tir']?></td>
	  	    		<td><?= $item->oborud['oborud']?></td>           							
	  	    		<td><?= $item['start']?></td>           							
	  	    		<td><?= $item['end']?></td>           							
	                <td><?= $item['progon']?></td>
	                <td><?= $item['timerab']?></td>
	                <td><?= $item['comments']?></td>
	            </tr>
	        <?php endforeach?>
	        </tbody>
	    </table>
   	</div>
   	<?= Html::a('Закрыть', ['order/index'], ['class' => 'btn btn-success']) ?>        
</div>

<hr/>
<h4>Редактирование заказа</h4>
<div class="order-form">
    <?php $form = ActiveForm::begin(); ?>
	    <?= $form->field($orders, 'ending')->textInput(['class' => "tcal"]) ?>
	    <?= $form->field($orders, 'dop_info')->textInput() ?>
     	<div class="form-group">
        	<?= Html::submitButton($orders->isNewRecord ? 'Create' : 'Изменить', ['class' => $orders->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   		</div>
    <?php ActiveForm::end(); ?>
</div>
 