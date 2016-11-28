<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Oborud extends ActiveRecord {
 
    public static function tableName()
    {
        return 'oborud';
    }

    public function getTask(){
        return $this->hasMany(Task::className(), ['nob_oborud' => 'n_ob']);
    }
     
    public function rules() {
        return [
            [['n_ob', 'oborud', 'job_id'], 'required'],
            [['n_ob','job_id'], 'integer'],
	        [['oborud'], 'string'],
            [['oborud'], 'string', 'max' => 120],
        ];
    }
    
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'n_ob' => 'n_ob',
            'oborud' => 'Название',
            'job_id' => 'job_id',
        ];
    }
}
