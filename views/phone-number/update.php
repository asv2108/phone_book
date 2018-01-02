<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\PhoneNumber */

$this->title = Yii::t('app', 'Update Phone Number', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="phone-number-update col-md-6 col-md-offset-2">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
