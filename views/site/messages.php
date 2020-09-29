<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список нкорректных сообщений';
$this->params['breadcrumbs'][] = $this->title;
;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    /** @var array $messages */
    GridView::widget([
        'dataProvider' => $messages,
        'columns' => [
            [
                'attribute' => 'id',
                'label'=>'id'
            ],
            [
                'attribute' => 'login',
                'label'=>'Имя пользователя'
            ],
            [
                'attribute' => 'message',
                'label'=>'Сообщение'
            ],
            [
                'label' => '',
                'format' => 'raw',

                'value' => function($data){
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['/site/incorrect-messages/', 'id' => $data['id']]), [
                        'title' => Yii::t('yii', 'Cделать корректным')
                    ]);
                },
            ],
        ]
    ]);
    ?>
</div>
