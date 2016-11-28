<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Task extends ActiveRecord {
 
    public static function tableName()
    {
        return 'task';
    }

    public function getOrders(){
        return $this->hasOne(Orders::className(), ['nz' => 'nz_orders']);
    }
   	public function getOborud(){
        return $this->hasOne(Oborud::className(), ['n_ob' => 'nob_oborud']);
    }
   	public function getSost(){
        return $this->hasOne(Sost::className(), ['id' => 'sost']);
    }  
      
    public function rules() {
        return [
            [['nz_orders', 'tir'], 'required'],
            [['nz_orders', 'sost', 'nob_oborud','tir','progon','nrec'], 'integer'],
	        [['timerab', 'comments'], 'string'],
  /*          [['namemash'], 'string', 'max' => 120],*/
        ];
    }
    
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Заказ',
            'nomenklatura' => 'Номенклатура',
            'tir' => 'Тираж',
            'progon' => 'Листопрогон',
            'start' => 'Начало печати',
            'end' => 'Конец печати',
            'timerab' => 'Время печати',
            'nrec' => '№ очереди',
            'sost' => 'Статус',
            'comments' => 'Примечание',
        ];
    }
}
