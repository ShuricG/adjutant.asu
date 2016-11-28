<?php

use yii\helpers\Html;

$this->title = 'Просмотр заказа №: ' . $orders->num;

/*$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $orders->title, 'url' => ['view', 'id' => $orders->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="order-update">

    <h3><?= Html::encode($this->title) ?></h3>
  
    <?= $this->render('_form', compact('orders','task')) ?>

</div>
