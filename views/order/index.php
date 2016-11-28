<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4>Список заказов</h4>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-condensed">
		<thead>
			<tr class="info">
				<th>Статус</th>			
				<th>Заказ №</th>
				<th>Наименование</th>
				<th>Тираж</th>
				<th>Начало печати</th>				
				<th>Окончание печати</th>	
				<th>Отделка</th>	
				<th>Дата сдачи</th>							
				<th>Срок</th>
				<th>Примечание</th>				
			</tr>
		</thead>
		<tbody>
			<?php $num = -1;
			$ending = '1970-01-01';
			foreach($orders as $data) : ?>
				<tr>
					<?php if ($data['end_press'] !== $ending) {?>
						<td colspan="10" class="DateTitle"><h3><?= getDay($data['end_press']).' : '.getFormat($data['end_press']) ?></h3></td>	
					<?php $ending = $data['end_press']; } ?>	
				</tr>
				<?php if ($data['num'] !== $num) {?>
					<tr class="status<?=$data['sost_orders']?>">
						<td class="icon_status<?=$data['sost_orders']?>"<?= $data['title_status'] ?></td>	
						<td><a href="<?= \yii\helpers\Url::to(['order/update', 'id' => $data['nz_orders']])?>" data-id="<?= $data['id']?>"><?= $data['num'] ?></a></td>										
						<td><?= $data['title'] ?></td>										
						<td><?= $data['tirag'] ?></td>
						<td><?= getFormat($data['start_press']) ?></td>
						<td><?= getFormat($data['end_press']) ?></td>
						<td><?= $data['post_press'] ?></td>
						<td><?= getFormat($data['ending']) ?></td>						
						<td><?= getFormat($data['srok']) ?></td>											
						<td><?= $data['dop_info'] ?></td>	
						<!-- <td><a href="<?= \yii\helpers\Url::to(['order/view', 'id' => $data['nz_orders']])?>" data-id="<?= $data['id']?>" class="glyphicon glyphicon-eye-open text-primary"></a></td> -->
					</tr>
				<?php $num = $data['num']; } ?>							
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
