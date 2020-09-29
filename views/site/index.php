<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Чат';

?>
<div class="site-index">

    <div class="body-content">

        <h3 class=" text-center">Сообщения</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="mesgs">
                    <div class="msg_history">
                        <?if(isset($messages)):?>
                            <?for($i = 0; $i < count($messages); $i++):?>
                                <? if ((bool)$messages[$i]['incorrect']): ?>
                                        <? if(Yii::$app->user->can('admin')): ?>
                                            <div class="incoming_msg">
                                                <div class="incoming_msg_img">
                                                    <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                                    <? if(Yii::$app->user->can("admin")): ?>
                                                        <?=Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['/site/incorrect-messages/', 'id' => $messages[$i]['id']]), [
                                                            'title' => Yii::t('yii', 'Cделать корректным')
                                                        ])?>
                                                    <? endif; ?>
                                                    <p id="<?=$messages[$i]['id_author']?>" ><?=$messages[$i]['login']?></p>

                                                </div>
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p <?=(Yii::$app->user->can('admin') ? "style='background: #f44336; color: #fff;'" : '' ) ?>> <?=$messages[$i]['message']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <? endif; ?>
                                    <? else: ?>
                                        <? if((int)$messages[$i]['id_author'] == Yii::$app->user->getId()):?>
                                        <div class="outgoing_msg">
                                            <div class="sent_msg">
                                                <? if(Yii::$app->user->can("admin")): ?>
                                                    <?=Html::a('<span class="glyphicon glyphicon-eye-close"></span>', Url::to(['/site/incorrect-messages/', 'id' => $messages[$i]['id']]), [
                                                        'title' => Yii::t('yii', 'Cделать некорректным')
                                                    ])?>
                                                <? endif;?>
                                                <p <?=(Yii::$app->authManager->getAssignment('admin', $messages[$i]['id_author']) && !Yii::$app->user->can('admin') ? "style='background: #058f36; color: #fff;'" : '' ) ?>><?=$messages[$i]['message']?></p>
                                            </div>
                                        </div>
                                    <?else:?>
                                        <div class="incoming_msg">
                                            <div class="incoming_msg_img">
                                                <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                                <? if(Yii::$app->user->can("admin")): ?>
                                                    <?=Html::a('<span class="glyphicon glyphicon-eye-close"></span>', Url::to(['/site/incorrect-messages/', 'id' => $messages[$i]['id']]), [
                                                        'title' => Yii::t('yii', 'Cделать некорректным')
                                                    ])?>
                                                <? endif;?>
                                                <p id="<?=$messages[$i]['id_author']?>" ><?=$messages[$i]['login']?></p>
                                            </div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p <?=(Yii::$app->authManager->getAssignment('admin', $messages[$i]['id_author']) ? "style='background: #058f36; color: #fff;'" : '' ) ?>
                                                    ><?=$messages[$i]['message']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <? endif; ?>

                            <?endfor;?>
                        <?else:?>
                            <p class="msg_empty_history">История сообщений пуста.</p>
                        <?endif;?>

                    </div>
                    <div class="type_msg">
                        <?php if (Yii::$app->user->can('writeMessage')): ?>
                            <? $form = ActiveForm::begin([
                                'id' => 'send-message-form',
                            ])?>
                            <div class="input_msg_write">
                                <?=$form->field($messageForm, 'message')->textInput(['placeholder' => 'Введите сообщение', 'class' => 'write_msg'])->label('')?>
                                <?= Html::submitButton('<i class="fa fa-paper-plane-o" aria-hidden="true"></i>', ['class' => 'msg_send_btn', 'id' => 'sendMessage', 'name' => 'send_message', 'value' => 'send'])?>
                            </div>
                            <? ActiveForm::end(); ?>
                        <?php else: ?>
                            <p>Сообщения могут оставлять только <?=Html::a('авторизованные', '/site/login')?> пользователи.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
