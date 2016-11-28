<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\MenuBeginning;
use app\components\MenuOborud;
use app\components\MenuSost;
use app\components\CrumbsBread;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Refresh" content="60" />    
   	<?= Html::csrfMetaTags() ?>
   
    <?php $title_for_layout = Html::encode($this->title) ?>

	<title>АСУПП «Адъютант»</title>		
     
    <?php $this->head() ?>
	<link rel="shortcut icon" href="/web/favicon.ico" type="image/x-icon">   
    	
 </head>
<body>
<?php $this->beginBody() ?>
	<header>
       <div id="header">
           <div id="logo">
				<a href="<?=Yii::$app->urlManager->createUrl(['/'])?>"><img src="/images/banner.jpg" alt="Логотип" /></a>
			</div>
			<?= Html::a('Все заказы', ['order/index'], ['class' => 'btn btn-primary']) ?>
			<?= Html::a('Все задания', ['task/index'], ['class' => 'btn btn-primary']) ?>
			<?= Html::a('Справочники', "#", ['class' => 'btn btn-primary']) ?>			
			<?= Html::a('Диаграмма', "http://gant.asu", ['class' => 'btn btn-primary']) ?>
       </div>	
	</header>
 	<div class="clear"></div>
 	
	<div id="container">
		<div id="content">
			<div id="left">
				<?= MenuBeginning::widget()?>
				<?= MenuSost::widget()?>				
				<?= MenuOborud::widget()?>
			</div>
			<div id="center">
				<div class="main">
					<?= $content ?>
				</div>
			</div>
		</div>	
		<div class="clear"></div>
	</div>	
	
	<footer>
		<?php if(empty($title_for_layout)){ ?>
			<p>Адъютант</p>		
		<?php }
		else { ?>
			<p>Адъютант | <?php echo $title_for_layout; ?></p>
		<?php } ?>  
		<div id="endline"><p></p></div>		
	</footer>
	
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h4>Задание на печать</h4>',
    'id' => 'card',
    'size' => 'modal-sm',
/*    'footer' => '<a href="' . \yii\helpers\Url::to(['order/index']) . '" class="btn btn-success">Закрыть</a>'*/
]);
\yii\bootstrap\Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
