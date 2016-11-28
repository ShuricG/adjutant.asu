<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Order;

class MenuSrok extends Widget {

    public function run(){
  
 		$query = "SELECT DISTINCT beginning FROM task WHERE (beginning > 0 AND sost <> 3) ORDER BY beginning";
		$menus = Yii::$app->db->createCommand($query)->queryAll();
  
        return $this->render('srok_menu', compact('menus'));
    }
   
}

?>
