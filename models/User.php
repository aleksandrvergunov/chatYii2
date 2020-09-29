<?php

namespace app\models;

use developeruz\db_rbac\interfaces\UserRbacInterface;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface, UserRbacInterface {
    public $id;
    public $login;
    public $password;
    public $token;
    public $authKey;

    public static function tableName() {
        return 'users';
    }

    public static function findIdentity($id) {
        return isset($id) ? new static(User::find()->where(['id'=>$id])->asArray()->one()) : null;
    }
    
    public static function findByLogin($login) {
        $user = User::find()->select('*')->where(['login' => $login])->asArray()->one();
        return !empty($user) ? new static($user) : null;
    }
    
    public function validatePassword($password) {
        return $this->password === $password;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $user = User::find()->select('*')->where(['token' => $token])->asArray()->one();
        return !empty($user) ? new static($user) : null;
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function getUserName()
    {
        return $this->login;
    }
}
