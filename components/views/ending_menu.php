<div class="block">
	<div class="header">Окончание печати</div>
	<div class="content">
		<nav>
			<div>
				<?php if($menus) : ?>
					<?php foreach($menus as $menu) : ?>
						<a <?php if ($menu['end_press'] == Yii::$app->request->get('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['order/ending', 'id' => $menu['end_press']])?>"><?=getDay($menu['end_press']).' : '.getFormat($menu['end_press'])?></a>
					<?php endforeach; ?>  		
				<?php endif; ?>
			</div>
		</nav>
	</div>
</div>
