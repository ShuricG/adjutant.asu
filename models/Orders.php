<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Orders extends ActiveRecord {

    public static function tableName()
    {
        return 'orders';
    }

   public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
 /*                   ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],*/
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    public function getTask(){
        return $this->hasMany(Task::className(), ['nz_orders' => 'nz']);
    }

   public function getSost(){
 /*       return $this->hasMany(Sost::className(), ['id_sost' => 'sost'])->via('task');*/
        return $this->hasOne(Sost::className(), ['id_sost' => 'sost_orders']);
    }
    
    public function rules() {
        return [
            [['nz', 'num', 'title', 'tirag', 'srok', 'ending'], 'required'],
            [['nz','tirag'], 'integer'],
	        [['num','dop_info'], 'string'],
            [['title'], 'string', 'max' => 120],
        ];
    }

  	public function attributeLabels() {
        return [
            'id' => 'ID',
            'num' => 'Номер заказа',
            'title' => 'Наименование',
            'tirag' => 'Тираж',
            'ending' => 'Дата сдачи',
            'srok' => 'Срок',
            'dop_info' => 'Примечание',
           ];
    }
}
