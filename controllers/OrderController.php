<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrderController extends AppController
{
	public $layout = 'main';

 	public  $filter;
 	public	$query = "SELECT o.*, p.*, ob.oborud, jl.kod_jobs, s.*
				FROM orders o
		 		LEFT JOIN task p
		 		ON o.nz = p.nz_orders
		 		LEFT JOIN oborud ob
		 		ON ob.n_ob = p.nob_oborud
		 		LEFT JOIN jlist jl
		 		ON o.nz = jl.nz_orders		 		 				 		
		 		LEFT JOIN sost s
			 	ON o.sost_orders = s.id_sost";
 
    public function actionIndex()
    {
		$orders = Orders::find()->orderBy(['nz' => SORT_ASC])->all();
		$nz = -1;
		foreach($orders as $order) {			
			if ($order['nz'] !== $nz){
				$nz = $order['nz'];	
				$query = "SELECT MIN(p.start) as start_min, MAX(p.end)as end_max, MAX(p.sost)as sost_max
		 			FROM task p
		 			WHERE p.nz_orders = '$nz'";
				$data = Yii::$app->db->createCommand($query)->queryAll();
				
				$order['start_press'] = $data[0]['start_min'];
				$order['end_press'] = $data[0]['end_max'];
				if ($order['ending'] == '0000-00-00') {
					$order['ending'] = $data[0]['end_max'];	
				}
				$order['sost_orders'] = $data[0]['sost_max'];
				
				$query = "SELECT jl.*, j.*
		 			FROM jlist jl
		 			INNER JOIN jobs j
		 			ON j.kod = jl.kod_jobs
		 			WHERE jl.nz_orders = '$nz'";
				$data = Yii::$app->db->createCommand($query)->queryAll();
				
				$post_press = '';
				foreach ($data as $item) {
					$post_press = $post_press.' '.$item['vid_rabot'].' '.$item['kolvo'].' '.$item['ed_izm'].'; ';				
				}
				$order['post_press'] =	$post_press;		
				$order->save();
			}
		}				
		$query = $this->query." GROUP BY nz ORDER BY end_press";			
		$orders = Yii::$app->db->createCommand($query)->queryAll();
/*		if(empty($orders))
             throw new \yii\web\HttpException(404, 'К сожалению, запрошенная страница не существует.');		*/
        return $this->render('index', ['orders' => $orders,]);
    }

    public function actionView($id = null)
    {
        $id = Yii::$app->request->get('id');
		$query = $this->query." WHERE o.nz = '$id'";
		$orders = Yii::$app->db->createCommand($query)->queryAll();
		return $this->render('view', ['orders' => $orders,]);		
     }
 
   	public function actionEnding($id)
	{
	 	$query = $this->query." WHERE end_press = '$id' GROUP BY nz ORDER BY end_press";
		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
    
    public function actionSost($id) 
    {
	 	$query = $this->query." WHERE s.title_status = '$id' GROUP BY nz ORDER BY end_press";	
		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
    
   	public function actionJobs($id) 
    {
		$query = $this->query." WHERE jl.kod_jobs = '$id' GROUP BY nz ORDER BY end_press";
 		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
    
 	public function actionUpdate($id)
    {
  		$orders = Orders::find()->with('sost')->where(['nz' => $id])->limit(1)->one();
  		$task = Task::find()->with('oborud')->where(['nz_orders' => $orders['nz']])->all();
      	if( $orders->load(Yii::$app->request->post()) ){
            if($orders->save()){
               	if( !Yii::$app->request->isAjax ){
		            return $this->redirect(Yii::$app->request->referrer);
		        }              	
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
        return $this->render('update', compact('orders','task'));
    }
 
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
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
