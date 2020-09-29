<?php

namespace app\controllers;

use app\models\Messages;
use app\models\SendMessageForm;
use app\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $sendMessageFormModel = new SendMessageForm();

        if (Yii::$app->request->post('send_message')) {
            if ($sendMessageFormModel->load(Yii::$app->request->post()))
                $sendMessageFormModel::SendMessage(htmlspecialchars(Yii::$app->request->post('SendMessageForm')['message']));
            return $this->goHome();
        }
        
        return $this->render('index', [
            'messageForm' => $sendMessageFormModel,
            'messages' => Messages::getAllMessage()
        ]);
    }

    public function actionListUsers() {
        if (!Yii::$app->user->can('viewPageUsers')) {
            return $this->goHome();
        }
        $usersSearchModel = new UserSearch();
        
        return $this->render('users-list', [
            'usersList' => $usersSearchModel->search(Yii::$app->request->queryParams),
            'filterModel' => $usersSearchModel 
        ]);
    }
    
    public function actionIncorrectMessages() {
        if (!Yii::$app->user->can('admin')) {
            return $this->goHome();
        }
        
        if(Yii::$app->request->get('id')) {
            $id = (int)Yii::$app->request->get('id');
            Messages::changeStatusMessage($id);
        }
        
        return $this->render('messages', [
            'messages' =>  Messages::getAllIncorrectMessages()
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
