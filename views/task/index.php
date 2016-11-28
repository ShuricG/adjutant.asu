<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Задания';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4>Список заданий</h4>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-condensed">
		<thead>
			<tr class="info">
				<th>Заказ №</th>
				<th>Наименование</th>
				<th>Печатная машина</th>
				<th>Тираж</th>
				<th>Начало печати</th>
				<th>Окончание печати</th>
				<th>Время</th>
				<th>Срок</th>
				<th>№ п/п</th>
				<th> </th>
			</tr>
		</thead>
		<tbody>
			<?php $beginning = '1970-01-01'?>
			<?php foreach($orders as $data) : ?>
				<tr>
					<?php if ($data['beginning'] !== $beginning) {?>
						<td colspan="10"><h3><?= getDay($data['beginning']).' : '.getFormat($data['beginning']) ?></h3></td>	
					<?php $beginning = $data['beginning']; } ?>	
				</tr>
				<tr>
					<td class="sost<?=$data['id_sost']?>"><?= $data['num'] ?></td>
					<td><?= $data['nomenklatura']." - ".$data['title'] ?></td>										
					<td><?= $data['oborud'] ?></td>
					<td><?= $data['tir'] ?></td>
					<td><?= getFormatTime($data['start']) ?></td>
					<td><?= getFormatTime($data['end']) ?></td>
					<td><?= $data['timerab'] ?></td>
					<td><?= getFormat($data['srok']) ?></td>
					<td><?= $data['nrec'] ?></td>
					<td><a href="<?= \yii\helpers\Url::to(['card/update', 'id' => $data['id']])?>" data-id="<?= $data['id']?>" class="update-card card glyphicon glyphicon-pencil text-primary"></a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
