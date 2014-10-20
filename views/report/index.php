<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $reportOneDataProvider yii\data\ActiveDataProvider */
/* @var $reportTwoDataProvider yii\data\ActiveDataProvider */
/* @var $reportThreeDataProvider yii\data\ActiveDataProvider */
?>
<h1>Отчеты</h1>

    <h4>
        1. Вывод списка книг, находящихся на руках у читателей, и имеющих не менее трех со-авторов.
    </h4>
<?= GridView::widget([
    'dataProvider' => $reportOneDataProvider,
    'columns' => [
        'id',
        [
            'attribute'=>'title',
            'format'=>'html',
            'value'=>function($model, $key, $index, $column){
                return Html::decode(Html::a($model->title, ['book/view', 'id'=>$key]));
            }
        ],
    ],
]); ?>
    <h4>
        2. Вывод списка авторов, чьи книги в данный момент читает более трех читателей.
    </h4>
<?= GridView::widget([
    'dataProvider' => $reportTwoDataProvider,
    'columns' => [
        'id',
        'name',
        'readers',
    ],
]); ?>
    <h4>
        3. Вывод пяти случайных книг.
    </h4>
<?if ($this->beginCache('randomBooksHtml', ['duration' => 5])) {?>
<?= GridView::widget([
    'dataProvider' => $reportThreeDataProvider,
    'columns' => [
        'id',
        'title',
    ],
]); ?>
<?$this->endCache();}?>