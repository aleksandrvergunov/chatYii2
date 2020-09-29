<?php

namespace app\models;

use Yii;
use yii\base\Model;


class SendMessageForm extends Model
{
    public $message;
    
    public function rules()
    {
        return [
            [['message'], 'required']
        ];
    }

    public static function SendMessage($message) {

        return Messages::addMessage(Yii::$app->user->getId(), $message);
    }
}
