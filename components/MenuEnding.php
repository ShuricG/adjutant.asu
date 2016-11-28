<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Order;

class MenuEnding extends Widget {

    public function run(){
  
 		$query = "SELECT DISTINCT end_press FROM orders WHERE (end_press > 0) ORDER BY end_press";
		$menus = Yii::$app->db->createCommand($query)->queryAll();
  
        return $this->render('ending_menu', compact('menus'));
    }
   
}

?>
