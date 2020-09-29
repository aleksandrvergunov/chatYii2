<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User {

    public function rules() {
        return [
            [['id'], 'integer'],
            [['login'], 'safe'],
        ];
    }

    public function formName() {
        return '';
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = self::find()->select("id, login");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate())
            return $dataProvider;

        if (isset($params['login']))
            $query->andFilterWhere(['login' => $this->login]);
        $query->asArray()->all();

        return $dataProvider;
    }
}
