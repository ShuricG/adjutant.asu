<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Task;
use app\models\Card;
use yii\helpers\Html;
use Yii;

class CardController extends AppController{

    public function actionAdd(){
        $id = Yii::$app->request->get('id');

        $task = Task::findOne($id);
        if(empty($task)) return false;
        
        $session =Yii::$app->session;
        $session->open();
        $session->remove('card');
        $card = new Card();
        $card->addToCard($task);
         
        if( !Yii::$app->request->isAjax ){
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;
        return $this->render('card-modal', compact('session'));
    }

    public function actionClear(){
        $session =Yii::$app->session;
        $session->open();
        $session->remove('card');
        $this->layout = false;
        return $this->render('card-modal', compact('session'));
    }

    public function actionDelItem(){
        $id = Yii::$app->request->get('id');
        $session =Yii::$app->session;
        $session->open();
        $card = new Card();
        $card->recalc($id);
        $this->layout = false;
        return $this->render('card-modal', compact('session'));
    }

    public function actionShow(){
        $session =Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('card-modal', compact('session'));
    }
    
   	public function actionEdit($id){
       	$this->layout = false;
        $orders = Orders::find()->where(['nz' => $id])->limit(1)->one();
        if( $orders->load(Yii::$app->request->post()) ){
            if($orders->save()){
               	if( !Yii::$app->request->isAjax ){
		            return $this->redirect(Yii::$app->request->referrer);
		        }              	
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
        return $this->render('edit', compact('session', 'orders'));
    }
    
    public function actionUpdate($id){
        $this->layout = false;
        $orders = Task::findOne($id);
        $nrec_old = $orders->nrec; 
        if( $orders->load(Yii::$app->request->post()) ){
            if($orders->save()){
                $orders = Task::findOne($id);
       			$nob = $orders->nob_oborud;                 
        		$nrec_new = $orders->nrec; 
 				if ($nrec_new < $nrec_old){
             		$orders = Task::find()->where(['nob_oborud' => $nob])->andWhere(['>=', 'nrec', $nrec_new])->orderBy(['nrec' => SORT_ASC])->all();					
				}
				else {
                	$orders = Task::find()->where(['nob_oborud' => $nob])->andWhere(['>=', 'nrec', $nrec_old])->orderBy(['nrec' => SORT_DESC])->all();					
				}
	    		foreach($orders as $task) {
	    			if ($nrec_new == $nrec_old){
						$task['pg'] = 1; 	
					}
	    			if (($task['id'] !== $id) && ($nrec_new < $nrec_old)){
						if ($task['nrec'] <= $nrec_old){
							$task['nrec'] = $task['nrec'] + 1;	
							$task['pg'] = 1; 						
						}
					}
	    			if (($task['id'] !== $id) && ($nrec_new > $nrec_old)){
						if ($task['nrec'] <= $nrec_new){
							$task['nrec'] = $task['nrec'] - 1;	
							$task['pg'] = -1; 						
						}
					}							
	    			$task['start'] = ''; 	
	    			$task['end'] = ''; 
	    			$task->save();	
	    		}
	    		
 /*             return $this->goHome();*/
             	if( !Yii::$app->request->isAjax ){
		            return $this->redirect(Yii::$app->request->referrer);
		        }              	
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
        return $this->render('update', compact('session', 'orders'));
    }

    protected function findModel($id)
    {
        if (($orders = Task::findOne($id)) !== null) {
            return $orders;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

} 