<div class="dropdown">  
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		Оборудование <span class="caret"></span>
	</button>
  	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
  		<li><b>Печатное</a></b>
  		<li class = "divider"></li>
 			<?php foreach($menus as $menu) : ?>
				<li><a <?php if ($menu['id'] == Yii::$app->getRequest()->getQueryParam('id')) { ?>class="active"<?php } ?> href="<?=Yii::$app->urlManager->createUrl(['order/oborud', 'id' => $menu['n_ob']])?>"><?=$menu['oborud']?></a></li>
			<?php endforeach; ?>  		
   	</ul>
</div>	
		