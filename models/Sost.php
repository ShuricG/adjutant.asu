<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Sost extends ActiveRecord {
 
    public static function tableName()
    {
        return 'sost';
    }

   public function getTask(){
        return $this->hasMany(Task::className(), ['sost' => 'id_sost']);
    }
 
   public function getOrders(){
        return $this->hasMany(Orders::className(), ['sost_orders' => 'id_sost']);
    }
     
    public function rules() {
        return [
            [['title_status', 'description'], 'required'],
  	        [['description', 'title_status'], 'string'],
          ];
    }
    
    public function attributeLabels() {
        return [
            'id_sost' => 'ID',
            'title_status' => 'Название',
            'description' => 'Описание',
       ];
    }
}
