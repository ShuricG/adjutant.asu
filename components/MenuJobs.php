<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Jobs;

class MenuJobs extends Widget {

    public function run(){
        // get cache
        $menus = Yii::$app->cache->get('menujobs');
        if($menus){
 	  		return $this->render('jobs_menu', compact('menus'));
		}
 		$menus = Jobs::find()->orderBy(['orderRabot' => SORT_ASC])->all();
 
        // set cache
        Yii::$app->cache->set('menujobs', $menus, 600);
  
        return $this->render('jobs_menu', compact('menus'));
    }
   
}

?>
