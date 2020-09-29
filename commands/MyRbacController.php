<?php
namespace app\commands;


use Yii;
use yii\console\Controller;

class MyRbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
        
        $admin = $auth->createRole('admin');
        $admin->description = 'Роль администратора';
        $user = $auth->createRole('user');
        $user->description = 'Роль пользователя';

        $auth->add($admin);
        $auth->add($user);


        $viewTableUsers = $auth->createPermission('viewPageUsers');
        $viewTableUsers->description = 'Просмотр страницы с пользователями';

        $writeMessage = $auth->createPermission('writeMessage');
        $writeMessage->description = 'Писать сообщения';
        
        $auth->add($viewTableUsers);
        $auth->add($writeMessage);


        $auth->addChild($user,$writeMessage);
        
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $viewTableUsers);
        
        $auth->assign($admin, 1);
        $auth->assign($user, 2);
    }
}