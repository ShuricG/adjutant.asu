<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Jobs extends ActiveRecord {
 
    public static function tableName()
    {
        return 'jobs';
    }

 /*  public function getTask(){
        return $this->hasMany(Task::className(), ['sost' => 'id']);
    }
     */
    public function rules() {
        return [
            [['kod', 'vid_rabot'], 'required'],
            [['kod'], 'integer'],
	        [['vid_rabot'], 'string'],
          ];
    }
    
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'kod' => 'kod',
            'vid_rabot' => 'Вид работ',
       ];
    }
}
