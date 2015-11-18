<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = $title;
$this->params['breadcrumbs'][] = [
    'label' => 'Компании',
    'url' => Url::to(['/company/index']),
];
if($action == "update"){
    $this->params['breadcrumbs'][] = [
        'label' => $model->fullName,
        'url' => Url::to(['/company/view', 'id' => $model->id]),
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<?
$form = ActiveForm::begin([
    'id' => 'company-form',
])
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Карточка предприятия</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'companyParam1')->dropDownList($model->typeArr) ?>
                    <?= $form->field($model, 'fullName') ?>
                    <?= $form->field($model, 'shortName') ?>
                    <?= $form->field($model, 'city') ?>
                    <?= $form->field($model, 'companyParam2') ?>
                    <?= $form->field($model, 'companyParam3') ?>
                    <?= $form->field($model, 'companyParam4') ?>
                    <?= $form->field($model, 'companyParam5') ?>
                    <?= $form->field($model, 'companyParam6') ?>
                    <?= $form->field($model, 'companyParam7') ?>
                    <?= $form->field($model, 'companyParam8') ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Банковские реквезиты</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'companyParam9') ?>
                    <?= $form->field($model, 'companyParam10') ?>
                    <?= $form->field($model, 'companyParam11') ?>
                    <?= $form->field($model, 'companyParam12') ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Учетная запись</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'password') ?>
                </div>
            </div>
            <? if(Yii::$app->user->identity->access > 50): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Персональный менеджер</h4>
                    </div>
                    <div class="panel-body">
                        <?= $form->field($model, 'managerId')->dropDownList($managers) ?>
                    </div>
                </div>
            <? endif ?>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Руководитель или контактное лицо</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'companyParam13') ?>
                    <?= $form->field($model, 'companyParam14') ?>
                    <?= $form->field($model, 'companyParam15') ?>
                    <?= $form->field($model, 'companyParam16') ?>
                    <?= $form->field($model, 'companyParam17') ?>
                    <?= $form->field($model, 'companyParam18') ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Главный бухгалтер</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'companyParam20') ?>
                    <?= $form->field($model, 'companyParam21') ?>
                    <?= $form->field($model, 'companyParam22') ?>
                    <?= $form->field($model, 'companyParam23') ?>
                    <?= $form->field($model, 'companyParam24') ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'companyParam19')->textarea(['class' => 'tinymce']) ?>
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