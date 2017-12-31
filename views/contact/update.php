<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = Yii::t('app', 'Update Contact: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->registerJsFile('@web/js/add-number.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$contact_id = $model->id;
?>
<div class="contact-update col-md-6">
    <div class="contact-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Update the contact '), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
<div class="contact-numbers col-md-6">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'caption' => 'List of contact\'s numbers:',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'number'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => ['width' => '60'],
                'urlCreator'=>function ($action, $model, $key, $index) use ($contact_id){
                    $action = '/phone-number/'.$action;
                    return [$action,'id'=>$model->id,'contact_id'=>$contact_id];
                },
            ],
        ],
    ]); ?>
    <p>
        <?php if($count<10): ?>
            <button type="button" data-id="<?=$model->id ?>" class="btn btn-primary create-number" data-toggle="modal" data-target="#modal-create"><span class=""></span>Create a new number</button>
        <?php endif;?>
    </p>
</div>
<div class="modal fade bs-example-modal-sm" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?php $form=ActiveForm::begin(['method' => 'post','id'=>'new-number']); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Добавить новый номер</h4>
            </div>
            <div class="modal-body">
                <?=$form->field($phone_model,'contact_id')->textInput(['type'=>'hidden','value'=>$model->id])->label(false)?>
                <?=$form->field($phone_model,'number')->textInput(['maxlength'=>true,'required'=>'required'])?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <!--   we send this form thought  add-number.js            -->
                <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary button-create']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
