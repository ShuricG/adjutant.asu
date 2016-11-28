<?php

namespace app\components;
use yii\base\Widget;
use app\models\Menu;
use Yii;

class CrumbsBread extends Widget{

    public function run(){
       	$menu = Yii::$app->cache->get('crumbs');
       	
 		if(!$menu){
			$menu = Menu::find()->indexBy('id')->asArray()->orderBy(['id' => SORT_DESC])->all();	
			Yii::$app->cache->set('crumbs', $menu, 60);
		}
		
		$id = Yii::$app->getRequest()->getQueryParam('id');		
		if ($id > 1) {
			$breadcrumbs_array = $this->breadcrumbs($menu, $id);
			if($breadcrumbs_array){
				$breadcrumbs = "Вы здесь: <a href='/'>ГЛАВНАЯ</a> - ";
				foreach($breadcrumbs_array as $link => $title){
					$breadcrumbs .= "<a href='{$link}'>{$title}</a> - ";
				}
				$breadcrumbs = rtrim($breadcrumbs, " - ");
				$breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
			}
			return $breadcrumbs;				
		}		
		else {
			return false;
		}
	}

	function breadcrumbs($menu, $id){
		if(!$id) return false;
		$data = array();
		foreach($menu as $item){
			if($item['id'] == $id){
				$data[$item['alias'].'.html'] = $item['title'];
				$id = $item['parent_id'];
			}
		}
		return array_reverse($data, true);
	}
}