<?php
	// функция для определения дня недели
	function getDay($data){
		$days = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
		// номер дня недели
		$num_day = strftime("%w", strtotime($data));
		$name_day = $days[$num_day];
		return $name_day;
	}
?>

<div class="block">
	<div class="header">План работ на</div>
	<div class="content">
		<nav>
			<div>
				<?php if($menus) : ?>
					<?php foreach($menus as $menu) : ?>
						<a <?php if ($menu['beginning'] == Yii::$app->request->get('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['order/srok', 'id' => $menu['beginning']])?>"><?=getDay($menu['beginning']).' : '.$menu['beginning']?></a>
					<?php endforeach; ?>  		
				<?php endif; ?>
			</div>
		</nav>
	</div>
</div>
