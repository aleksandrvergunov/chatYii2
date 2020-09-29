<?php

namespace app\models;

use Yii;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $id_author
 * @property string $message
 * @property string $incorrect
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_author', 'message'], 'required'],
            [['id_author'], 'integer'],
            [['message'], 'string', 'max' => 500],
        ];
    }

    public static function addMessage($id_author, $message) {
        if (!empty($message))
            return Yii::$app->db->createCommand("INSERT INTO messages (id_author, message) 
                VALUES ($id_author, '$message')")->execute() ? true : false;

        return ['sendedMessage' => 'error'];
    }
    
    public static function getAllMessage() {
        return self::find()->select("`messages`.*, `users`.login")->innerJoin('users', 'users.id  = messages.id_author')->asArray()->all();
    }
    
    public static function getAllIncorrectMessages() {
        return new ArrayDataProvider([
            'allModels' => self::find()
                ->select("`messages`.*, `users`.login")
                ->innerJoin('users', 'users.id  = messages.id_author')
                ->where(['messages.incorrect' => 1])
                ->asArray()
                ->all()
        ]);
    }

    public static function changeStatusMessage($id) {
        return Yii::$app->db->createCommand("UPDATE messages SET incorrect = !incorrect WHERE id = '$id'")->execute();
    }
}
