<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Oborud;

class MenuOborud extends Widget {

    public function run(){
        // get cache
        $menus = Yii::$app->cache->get('menuoborud');
        if($menus){
 	  		return $this->render('oborud_menu', compact('menus'));
		}
 		$menus = Oborud::find()->orderBy(['oborud' => SORT_ASC])->all();
 
        // set cache
        Yii::$app->cache->set('menuoborud', $menus, 600);
  
        return $this->render('oborud_menu', compact('menus'));
    }
   
}

?>
