<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Contact'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'first_name',
            'second_name',
            'last_name',
            [
                'attribute'=>'number',
                'value' => function ($data) {
                    $db_numbers = $data->numbers;
                    $numbers = ' ';
                    foreach ($db_numbers as $db_number) {
                        $numbers .= $db_number['number'] . ' ';
                    }
                    return $numbers;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
$this->registerJs(
    "$('a[title=\"Delete\"]').css('color','red');",
    View::POS_READY,
    'delete-color'
);
