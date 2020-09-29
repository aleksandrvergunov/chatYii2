<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    /** @var array $usersList */
    /** @var array $filterModel */
    GridView::widget([
        'dataProvider' => $usersList,
        'filterModel' => $filterModel,
        'columns' => [
            [
                'attribute' => 'id',
                'label'=>'id'
            ],
            [
                'attribute' => 'login',
                'label'=>'Имя пользователя'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{permit}',
                'buttons' =>
                    [
                        'permit' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-wrench"></span>', Url::to(['/permit/user/view', 'id' => $model['id']]), [
                                'title' => Yii::t('yii', 'Изменить роль')
                            ]); },
                    ]
            ],
        ]
    ]);
    ?>
</div>
