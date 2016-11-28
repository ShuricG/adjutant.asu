<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр заказа';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-view">

    <h3>Просмотр заказа № <?= $orders[0]['num'] ?></h3>
 	<form action="#">
		<!-- add class="tcal" to your input field -->
		<div><input type="text" name="date" class="tcal" value="" /></div>
	</form>
  	<div class="table-responsive">
	    <table class="table table-hover table-striped">
			<tr>
			    <th>Наименование</th><td><?= $orders[0]['title']?></td>     
			</tr>
			<tr>    
			    <th>Тираж</th><td><?= $orders[0]['tirag']?></td>
			</tr>
			<tr>    
			    <th>Начало печати</th><td><?= $orders[0]['start_press']?></td>
			</tr>
			<tr>    
			    <th>Окончание печати</th><td><?= $orders[0]['end_press']?></td>
			</tr>
			<tr>    
			    <th>Отделка</th><td><?= $orders[0]['post_press']?></td>
			</tr>		
			<tr>    
			    <th>Дата сдачи</th><td><?= $orders[0]['ending']?></td>
			</tr>					
			<tr>    
			    <th>Срок</th><td><?= $orders[0]['srok']?></td>
			</tr>
			<tr>    
			    <th>Статус</th><td><?= $orders[0]['title_status']?></td>
			</tr>
			<tr>    
			    <th>Примечание</th><td><?= $orders[0]['dop_info']?></td>
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
	        <?php foreach($orders as $item):?>
	            <tr>
	                <td><a href="<?= \yii\helpers\Url::to(['#', 'id' => $item->id])?>"><?= $item['nomenklatura']?></a></td>
	                <td><?= $item['tir']?></td>
	  	    		<td><?= $item['oborud']?></td>           							
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
  	<div>
  		<a href="<?= \yii\helpers\Url::to(['card/edit', 'id' => $orders[0]['nz']])?>" data-id="<?= $orders[0]['nz']?>" class="edit-card card btn btn-primary">Редактировать</a>
        <?= Html::a('Закрыть', ['order/index'], ['class' => 'btn btn-primary']) ?>
    </div>

</div>
