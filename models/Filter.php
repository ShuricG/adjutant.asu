<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Filter extends ActiveRecord {
 
    public static function tableName()
    {
        return 'filter';
    }

 /*  public function getTask(){
        return $this->hasMany(Task::className(), ['sost' => 'id']);
    }
     
    }*/
}
