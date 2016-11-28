<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TaskController extends AppController
{
 	public $layout = 'task';
  	
 	public  $filter;
 	public	$query = "SELECT o.*, p.*, ob.oborud, s.*
				FROM orders o
		 		LEFT JOIN task p
		 		ON o.Nz = p.nz_orders
		 		LEFT JOIN oborud ob
		 		ON ob.N_ob = p.nob_oborud
		 		LEFT JOIN sost s
			 	ON s.id_sost = p.sost";
 
 	public function events()
	{
		// объединение заданий для перемещения в очереди
		$this->preQueue();
		// создание очереди заданий
		$this->Queue();
		// сортировка заданий по каждой машине
		$this->sortTask();		
	}
 	
    public function actionIndex()
    {
		$this->events();
		$query = $this->query." ORDER BY p.start";			

		$orders = Yii::$app->db->createCommand($query)->queryAll();
/*		if(empty($orders))
             throw new \yii\web\HttpException(404, 'К сожалению, запрошенная страница не существует.');		*/
        return $this->render('index', ['orders' => $orders,]);
  	}
 
    public function actionBeginning($id)
	{
	 	$this->events();
	 	$query = $this->query." WHERE p.beginning = '$id' ORDER BY p.start";
		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
    
  	public function actionOborud($id) 
    {
 	 	$this->events();		
 		$query = $this->query." WHERE ob.N_ob = '$id' ORDER BY p.start";
 		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
 
    public function actionSost($id) 
    {
	 	$this->events();	 	
	 	$query = $this->query." WHERE s.description = '$id' ORDER BY p.start";	
		$orders = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index', ['orders' => $orders]);
    }
    
 	public function actionUpdate($id)
    {
        $orders = $this->findModel($id);
        if ($orders->load(Yii::$app->request->post()) && $orders->save()) {
            return $this->redirect(['view', 'id' => $orders->id]);
        } else {
            return $this->render('update', [
                'orders' => $orders,
            ]);
        }
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
    
    protected function sortTask()
    {
		$orders = Task::find()->orderBy(['nob_oborud' => SORT_ASC])->all();
		$nob = -1;
		foreach($orders as $task) {			
			if ($task['nob_oborud'] !== $nob){
				$nob = $task['nob_oborud'];				
				$queue = Task::find()->where(['nob_oborud' => $nob])->orderBy(['start' => SORT_ASC])->all();
				$nrec = 0;			
				foreach($queue as $data) {
					$nrec = $nrec + 1;
					$data['nrec'] = $nrec;	
					$data->save();		
				}
			}
		}
	}	

   	protected function preQueue()
   	{
		$queue = Task::find()->orderBy(['nob_oborud' => SORT_ASC])->all();
		// объединение заданий для перемещения в очереди
		$nob = -1;
		foreach($queue as $task) {			
			if ($task['nob_oborud'] !== $nob){
				$nob = $task['nob_oborud'];	
				if ($task['pg'] == 1){
					$query = "SELECT p.*
			 			FROM task p
			 			WHERE nob_oborud = '$nob'
			 			ORDER BY p.nz_orders, p.nomenklatura, p.nrec ASC";					
				}	
				else{
					$query = "SELECT p.*
		 				FROM task p
		 				WHERE nob_oborud = '$nob'
		 				ORDER BY p.nz_orders, p.nomenklatura, p.nrec DESC";					
				}		
				$data = Yii::$app->db->createCommand($query)->queryAll();
							
				$nz_orders = -1;
				$nomenklatura = '';
				foreach($data as $dat) {
					if (($dat['nz_orders'] !== $nz_orders) or ($dat['nomenklatura'] !== $nomenklatura)){
						$nz_orders = $dat['nz_orders'];
						$nomenklatura = $dat['nomenklatura'];
						// сохранение номенклатуры для объединения
						$id_save = $dat['id'];
					}
					else {
						// длительность присоединяемого задания
						$timerab =  explode(':',$dat['timerab']);			
						$rabH_t = $timerab[0];
						$rabM_t = $timerab[1];
						$rabS_t = $timerab[2];	
						
						// открытие сохраненной номенклатуры
						$orders = $this->findModel($id_save);
						// длительность сохраненной номенклатуры
						$timerab_save = $orders->timerab;
						$timerab =  explode(':',$timerab_save);			
						$rabH_s = $timerab[0];
						$rabM_s = $timerab[1];
						$rabS_s = $timerab[2];	
						
						date_default_timezone_set( 'Europe/Moscow' );
						$dt_element = explode(' ',date('Y-m-d H:i:s'));
						$date_element = explode('-',$dt_element[0]);
						// сложение длительностей работы
						$end_time = mktime($rabH_t+$rabH_s, $rabM_t+$rabM_s, $rabS_t+$rabS_s, $date_element[1],$date_element[2],$date_element[0]);					
								
						$orders->timerab = date('H:i:s',($end_time));							
						$orders->start = '';
						$orders->end = '';
						
						// запись номенклатуры для объединения
						$orders->save();
						// удаление текущего задания
						$this->findModel($dat['id'])->delete();					
					}
				}
			}
		}		
	}

   	protected function Queue()
    {
		$orders = Task::find()->where(['>', 'nob_oborud', 0])->orderBy(['nrec' => SORT_ASC])->all();
		if ($orders !== null) {
			$timerab_save = ''; 
    		foreach($orders as $task) {
				$nob = $task['nob_oborud'];
				$nz_orders = $task['nz_orders'];
				$name = $task['name'];
				$nomenklatura = $task['nomenklatura'];
				$sost = $task['sost'];
				$tir = $task['tir'];
				$progon = $task['progon'];
				$comments = $task['comments'];
				
				if ($task['start'] == '') {
					$query = "SELECT MAX(p.nrec)as nrec_max, MAX(p.end)as end_max, ob.worksBegin, ob.worksHours 
			 			FROM task p
			 			LEFT JOIN oborud ob
	 					ON ob.N_ob = p.nob_oborud	
			 			WHERE nob_oborud = '$nob'";
						$data = Yii::$app->db->createCommand($query)->queryAll();

	// начало задания
					
					$worksBegin =  explode(':',$data[0]['worksBegin']);
					$rabEndH = $data[0]['worksHours'];
					
					if ($data[0]['end_max'] == '') {
						date_default_timezone_set( 'Europe/Moscow' );
						$dt_element = explode(' ',date('Y-m-d H:i:s'));
						$date_element = explode('-',$dt_element[0]);
						$time_element = explode(':',$dt_element[1]);
						$dat_tek_time = mktime($time_element[0],$time_element[1],$time_element[2], $date_element[1],$date_element[2],$date_element[0]);
						$delta_day = 0;
						$num_day = strftime("%w", strtotime(date('Y-m-d H:i:s')));
						if ($num_day == 6) {
							$delta_day = 1;
						}
						if ($num_day == 0) {
							$delta_day = 2;
						}							
						// конец раб дня 				
						$worksEnd_time = mktime($worksBegin[0]+$rabEndH, $worksBegin[1], $worksBegin[2], $date_element[1],$date_element[2]-$delta_day,$date_element[0]);
						if ($dat_tek_time < $worksEnd_time){
							//начало с тек даты
							$task['start'] = date('Y-m-d H:i:s');
						}
						else {
							$delta_day = 1;
							if ($num_day == 5) {
								$delta_day = 3;
								}
							if ($num_day == 6) {
								$delta_day = 2;
							}
							$worksBeg_time = mktime($worksBegin[0],$worksBegin[1],$worksBegin[2], $date_element[1],$date_element[2]+$delta_day,$date_element[0]);	
							// начало со след даты					
							$task['start'] = date('Y-m-d H:i:s',$worksBeg_time);							
						}
						$task['nrec'] = 1;		
					}
					
					// задание пристыковывается к предыдущему	
											
					else {
						$dt_element = explode(' ',$data[0]['end_max']);
						$date_element = explode('-',$dt_element[0]);
						$time_element = explode(':',$dt_element[1]);

						// конец раб дня 				
						$worksEnd_time = mktime($worksBegin[0]+$rabEndH, $worksBegin[1], $worksBegin[2], $date_element[1],$date_element[2],$date_element[0]);		
						$ending = date('Y-m-d H:i:s',$worksEnd_time);

						if ($data[0]['end_max'] < $ending) {
							// стыковка
							$task['start'] = $data[0]['end_max'];
						}
						// начало задания переходит на новый день 
						else {
							$num_day = strftime("%w", strtotime($data[0]['end_max']));
							$delta_day = 1;
							if ($num_day == 5) {
								$delta_day = 3;
								}
							if ($num_day == 6) {
								$delta_day = 2;
							}
							$worksBeg_time = mktime($worksBegin[0],$worksBegin[1],$worksBegin[2], $date_element[1],$date_element[2]+$delta_day,$date_element[0]);						
							$task['start'] = date('Y-m-d H:i:s',$worksBeg_time);
						}
						if ($task['pg'] !== 1){
							$task['nrec'] = $data[0]['nrec_max'] + 1;												
						}
					}
					$task['pg'] = 0;	
					$task['beginning'] = $task['start'];
					$nrec = $task['nrec'];
	// окончание расчета начала задания
	
	
	// расчет конца задания	
					$dt_element = explode(' ',$task['start']);
					$date_element = explode('-',$dt_element[0]);
					$time_element = explode(':',$dt_element[1]);
					
					// длительность работы
					if ($timerab_save == '') {
						$timerabFull =  explode(':',$task['timerab']);						
					}
					// длительность работы увеличивается с предыдущего дня					
					else {
						$timerab =  explode(':',$task['timerab']);			
						$rabH_t = $timerab[0];
						$rabM_t = $timerab[1];
						$rabS_t = $timerab[2];						
			
						$timerab =  explode(':',$timerab_save);			
						$rabH_s = $timerab[0];
						$rabM_s = $timerab[1];
						$rabS_s = $timerab[2];						
						$end_time = mktime($rabH_t+$rabH_s, $rabM_t+$rabM_s, $rabS_t+$rabS_s, $date_element[1],$date_element[2],$date_element[0]);					
						
						$task['timerab'] = date('H:i:s',($end_time));
						$timerabFull =  explode(':',$task['timerab']);						
					}
					$rabH = $timerabFull[0];
					$rabM = $timerabFull[1];
					$rabS = $timerabFull[2];
		
					// конец задания 					
					$end_time = mktime($time_element[0]+$rabH, $time_element[1]+$rabM, $time_element[2]+$rabS, $date_element[1],$date_element[2],$date_element[0]);
					
					// конец раб дня 				
					$worksEnd_time = mktime($worksBegin[0]+$rabEndH, $worksBegin[1], $worksBegin[2], $date_element[1],$date_element[2],$date_element[0]);									

					if ($end_time <= $worksEnd_time) {
						// работа полностью в тек дне
						$task['end'] = date('Y-m-d H:i:s',$end_time);
	       				$task->save();		
					}
					
					// переход на следующий день
					
					else{
						// остаток задания до конца раб дня					
						$task['end'] = date('Y-m-d H:i:s',$worksEnd_time);
						$end = $task['end'];

						// остаток времени работы до конца раб дня			
						$begin_time = mktime($time_element[0], $time_element[1], $time_element[2], $date_element[1],$date_element[2],$date_element[0]);	
						date_default_timezone_set('UTC');
						$task['timerab'] = date('H:i:s',$worksEnd_time - $begin_time);
	       				$task->save();											
					
						// новое задание 
						$num_day = strftime("%w", strtotime($task['end']));
						$delta_day = 1;
						if ($num_day == 5) {
							$delta_day = 3;
							}
						if ($num_day == 6) {
							$delta_day = 2;
						}
						
						// начало нового задания
						$worksBeg_time = mktime($worksBegin[0], $worksBegin[1], $worksBegin[2], $date_element[1], $date_element[2]+$delta_day, $date_element[0]);							
						$start = date('Y-m-d H:i:s',$worksBeg_time);
						
						// конец нового задания
						$worksBeg_time_Full = mktime($worksBegin[0]+$rabH, $worksBegin[1]+$rabM, $worksBegin[2]+$rabS, $date_element[1], $date_element[2], $date_element[0]);									
						
						$timerabUp =  explode(':',$task['timerab']);
						$rabH = $timerabUp[0];
						$rabM = $timerabUp[1];
						$rabS = $timerabUp[2];
						$worksBeg_time_Up = mktime($worksBegin[0]+$rabH, $worksBegin[1]+$rabM, $worksBegin[2]+$rabS, $date_element[1], $date_element[2], $date_element[0]);	
														
						date_default_timezone_set('UTC');
						$timerab_new = date('H:i:s',$worksBeg_time_Full - $worksBeg_time_Up);	
											
						$timerabDown =  explode(':',$timerab_new);
						$rabH = $timerabDown[0];
						$rabM = $timerabDown[1];
						$rabS = $timerabDown[2];						
						$end_time = mktime($worksBegin[0]+$rabH, $worksBegin[1]+$rabM, $worksBegin[2]+$rabS, $date_element[1],$date_element[2]+$delta_day, $date_element[0]);	
						$end = date('Y-m-d H:i:s',$end_time);

						$nrec = $nrec + 1;
	
						$query = "SELECT p.*
				 			FROM task p
				 			WHERE nz_orders = '$nz_orders' AND p.nomenklatura = '$nomenklatura' AND p.nrec = '$nrec' AND nob_oborud = '$nob' ";
							$data_rec = Yii::$app->db->createCommand($query)->queryAll();	
			
						if ($data_rec) {	
							$timerab_save = $timerab_new;
						}
						else {
							$timerab_save = '';
							$query = "INSERT INTO task (nz_orders, nrec, name, nomenklatura, start, end, beginning, sost, nob_oborud ,tir, progon,timerab, comments) VALUES ('$nz_orders', '$nrec', '$name', '$nomenklatura', '$start', '$end', '$start', '$sost', '$nob', '$tir','$progon','$timerab_new','$comments')";
							$new_rec = Yii::$app->db->createCommand($query);									
			       			$new_rec->execute();										
						}
					}
				}
			}
		}
	}
	
}
