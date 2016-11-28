<div class="block">
	<div class="header">План работ на</div>
	<div class="content">
		<nav>
			<div>
				<?php if($menus) : ?>
					<?php foreach($menus as $menu) : ?>
						<a <?php if ($menu['beginning'] == Yii::$app->request->get('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['task/beginning', 'id' => $menu['beginning']])?>"><?=getDay($menu['beginning']).' : '.getFormat($menu['beginning'])?></a>
					<?php endforeach; ?>  		
				<?php endif; ?>
			</div>
		</nav>
	</div>
</div>
