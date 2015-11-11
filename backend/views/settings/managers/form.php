<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = $title;
$this->params['breadcrumbs'][] = [
    'label' => 'Менеджеры',
    'url' => Url::to(['settings/managers/index']),
];
if($action == "update"){
    $this->params['breadcrumbs'][] = [
        'label' => $model->fullName,
        'url' => Url::to(['/managers/view', 'id' => $model->id]),
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<?
$form = ActiveForm::begin([
    'id' => 'managers-form',
    'options' => ['enctype' => 'multipart/form-data'],
])
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Карточка менеджера</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'firstName') ?>
                    <?= $form->field($model, 'secondName') ?>
                    <?= $form->field($model, 'thirdName') ?>
                    <?= $form->field($model, 'managerPhone') ?>
                    <? if (!$model->managerPhoto):?>
                        <?= $form->field($model, 'managerPhoto')->fileInput() ?>
                    <? endif ?>
                 </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Учетная запись</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <?= $form->field($model, 'email') ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'password') ?>
                    <?= $form->field($model, 'access')->dropDownList($model->rulesArr) ?>
                </div>
            </div>
        </div>
        <? if ($model->managerPhoto):?>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Фотография</h4>
                    </div>
                    <div class="panel-body">
                        <img width="100%" src="uploads/managers/<?= $model->managerPhoto ?>">
                        <a class="btn btn-danger pull-right remove-photo" href="<?= Url::to(['/settings/managers/removephoto', 'id' => $model->id]) ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                </div>
            </div>
        <? endif ?>
        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>