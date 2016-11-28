<div class="block">
	<div class="header">Статус</div>
	<div class="content">
		<nav>
			<div>
				<?php if($menus) : ?>
					<?php foreach($menus as $menu) : ?>
						<a <?php if ($menu['title_status'] == Yii::$app->request->get('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['order/sost', 'id' => $menu['title_status']])?>"><?=$menu['title_status']?></a>
					<?php endforeach; ?>  		
				<?php endif; ?>
			</div>
		</nav>
	</div>
</div>
