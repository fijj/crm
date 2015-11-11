<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = $model->company;
$this->params['breadcrumbs'][] = [
    'label' => 'Записная книжка',
    'url' => Url::to(['/helper/notebook/index']),
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <div class="btn-group btn-group-sm pull-right">
            <a class="btn btn-default" href="<?= Url::to(['/helper/notebook/new']) ?>">Создать</a>
            <a class="btn btn-warning" href="<?= Url::to(['/helper/notebook/update', 'id' => $model->id]) ?>">Редактировать</a>
            <a class="btn btn-danger" href="<?= Url::to(['/helper/notebook/remove', 'id' => $model->id]) ?>">Удалить</a>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-heading">
            <h4>
                <?= $model->company ?>
                <span class="label label-success"><?= $type[$model->type] ?></span>
            </h4>
        </div>
        <div class="col-lg-12">
            <?
            $form = ActiveForm::begin([
                'id' => 'company-form',
                'enableClientValidation' => false,
            ])
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Новая запись</h4>
                </div>
                <div class="panel-body">
                    <?= $form->field($historyModel, 'text')->textarea(['value' => '', 'class' =>'tinymce']) ?>
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary pull-right']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>История</h4>
                </div>
                <div class="panel-body">
                    <ul>
                        <? foreach ($history as $data): ?>
                            <? if($data->date != $lastdate):?>
                                <h5>
                                    <span class="label label-primary"><?= $data->date ?></span>
                                </h5>
                                <li><span class="label label-info"><?= $data->time ?></span>&nbsp;<?= $data->text ?></li>
                            <? else: ?>
                                <li><span class="label label-info"><?= $data->time ?></span>&nbsp;<?= $data->text ?></li>
                            <? endif; ?>
                            <? $lastdate = $data->date ?>
                        <? endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>