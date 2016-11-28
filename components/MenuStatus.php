<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Sost;

class MenuStatus extends Widget {

    public function run(){
        // get cache
        $menus = Yii::$app->cache->get('menustatus');
        if($menus){
 	  		return $this->render('status_menu', compact('menus'));
		}
  		$query = "SELECT DISTINCT title_status FROM sost ORDER BY id_sost";
 		$menus = Yii::$app->db->createCommand($query)->queryAll();
 
        // set cache
        Yii::$app->cache->set('menustatus', $menus, 600);
  
        return $this->render('status_menu', compact('menus'));
    }
   
}

?>
