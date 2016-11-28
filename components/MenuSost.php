<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Sost;

class MenuSost extends Widget {

    public function run(){
        // get cache
        $menus = Yii::$app->cache->get('menusost');
        if($menus){
 	  		return $this->render('sost_menu', compact('menus'));
		}
 		$menus = Sost::find()->orderBy(['id_sost' => SORT_ASC])->all();
 
        // set cache
        Yii::$app->cache->set('menusost', $menus, 600);
  
        return $this->render('sost_menu', compact('menus'));
    }
   
}

?>
