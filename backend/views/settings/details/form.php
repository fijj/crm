<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Реквизиты';
$this->params['breadcrumbs'][] = "Настройки -- ".$this->title;;
?>

<?
$form = ActiveForm::begin([
    'id' => 'details-form',
])
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Реквизиты компании</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'detailsFullName') ?>
                            <?= $form->field($model, 'detailsShortName') ?>
                            <?= $form->field($model, 'detailsParam1') ?>
                            <?= $form->field($model, 'detailsParam2') ?>
                            <?= $form->field($model, 'detailsParam3') ?>
                            <?= $form->field($model, 'detailsParam4') ?>
                            <?= $form->field($model, 'detailsParam5') ?>
                            <?= $form->field($model, 'detailsParam6') ?>
                            <?= $form->field($model, 'detailsParam7') ?>
                            <?= $form->field($model, 'detailsParam8') ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'detailsParam9') ?>
                            <?= $form->field($model, 'detailsParam10') ?>
                            <?= $form->field($model, 'detailsParam11') ?>
                            <?= $form->field($model, 'detailsParam12') ?>
                            <?= $form->field($model, 'detailsParam13') ?>
                            <?= $form->field($model, 'detailsParam14') ?>
                            <?= $form->field($model, 'detailsParam15') ?>
                            <?= $form->field($model, 'detailsParam16') ?>
                            <?= $form->field($model, 'detailsParam17') ?>
                            <?= $form->field($model, 'detailsParam18') ?>
                            <?= $form->field($model, 'detailsParam19') ?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>