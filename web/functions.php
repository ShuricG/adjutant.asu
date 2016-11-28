<?php

	// функция для определения дня недели
	function getDay($data){
		$days = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
		// номер дня недели
		$num_day = strftime("%w", strtotime($data));
		$name_day = $days[$num_day];
		return $name_day;
	}

	// функция для задания формата даты
	function getFormat($data){		
		if ($data == '0000-00-00') {
			$format_day	= '';
		}
		else{
			$date_element = explode('-',$data);
			$dat_time = mktime(0,0,0, $date_element[1],$date_element[2],$date_element[0]);
			$format_day = date('d.m.y',$dat_time);			
		}
		return $format_day;
	}	

	// функция для задания формата времени
	function getFormatTime($data){		
		if ($data == 'NULL') {
			$format_time	= '';
		}
		else{
			$dt_element = explode(' ',$data);
			$date_element = explode('-',$dt_element[0]);
			$time_element = explode(':',$dt_element[1]);			
			$dat_time = mktime($time_element[0],$time_element[1],$time_element[2], $date_element[1],$date_element[2],$date_element[0]);
			$format_time = date('H:i:s',$dat_time);			
		}
		return $format_time;
	}	

	function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
	}