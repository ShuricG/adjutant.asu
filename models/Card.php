<?php

namespace app\models;
use yii\db\ActiveRecord;

class Card extends ActiveRecord{

    public function addToCard($task){
        if(isset($_SESSION['card'][$task->id])){
            $_SESSION['card'][$task->id];
        }else{
            $_SESSION['card'][$task->id] = [
                'name' => $task->name,
                'nomenklatura' => $task->nomenklatura,
                'tir' => $task->tir,
                'progon' => $task->progon,
                'timerab' => $task->timerab,
                'comments' => $task->comments,
                'sost' => $task->sost
            ];
        }
    }

    public function recalc($id){
        if(!isset($_SESSION['card'][$id])) return false;
        unset($_SESSION['card'][$id]);
    }
} 