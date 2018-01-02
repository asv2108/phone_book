<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = Yii::t('app', 'Create Contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(isset($errors) && !empty($errors)):
    ?>
    <div class="error-message col-md-10 col-md-offset-2">
        <h1 class="text-danger"><?= $errors?></h1>
    </div>
    <?php
endif;
?>
<div class="contact-create col-md-6 col-md-offset-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
