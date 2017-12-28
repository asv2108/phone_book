<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = Yii::t('app', 'Update Contact: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');


?>
<div class="contact-update col-md-6">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<div class="contact-numbers col-md-6">
    <p>
        <?= Html::a(Yii::t('app', 'Create Number'), ['number/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'caption' => 'Список номеров контакта:',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
                'urlCreator'=>function($action, $model, $key, $index){
                    $action = '/number/'.$action;
                    return [$action,'id'=>$model->id];
                },

            ],
        ],
    ]); ?>
</div>