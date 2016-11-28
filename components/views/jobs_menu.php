<div class="block">
	<div class="header">Отделка</div>
	<div class="content">
		<nav>
			<div>
				<?php if($menus) : ?>
					<?php foreach($menus as $menu) : ?>
						<a <?php if ($menu['kod'] == Yii::$app->request->get('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['order/jobs', 'id' => $menu['kod']])?>"><?=$menu['vid_rabot']?></a>
					<?php endforeach; ?>  		
				<?php endif; ?>
			</div>
		</nav>
	</div>
</div>
