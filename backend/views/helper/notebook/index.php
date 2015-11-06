<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Записная книжка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <div class="col-lg-6">
        <?
        $form = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'action' => Url::to(['helper/notebook/search']),
            'options' => [
                'class' => 'form-inline'
            ],
        ])
        ?>
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        <?= Html::input('','text','',['class' => 'form-control']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-6">
        <a class="btn btn-success pull-right" href="<?= Url::to(['/helper/notebook/new']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="sort-container">
                <span class="label label-primary"><?= $sort->link('id') ?></span>
                <span class="label label-primary"><?= $sort->link('company') ?></span>
                <span class="label label-primary"><?= $sort->link('type') ?></span>
                <span class="label label-primary"><?= $sort->link('status') ?></span>
                <span class="label label-primary"><?= $sort->link('cameFrom') ?></span>
                <span class="label label-primary"><?= $sort->link('callBack') ?></span>
                <span class="label label-primary"><?= $sort->link('ready') ?></span>
                <span class="label label-primary"><?= $sort->link('managerId') ?></span>
            </div>
        </div>
    </div>
<? foreach ($model as $data): ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-8">
            <a class="link-name" href="<?= Url::toRoute(['/helper/notebook/view', 'id' => $data->id]); ?>"><?= $data->company ?></a>
            <span class="company-temp" style="background-color:<?= $data->readyArr[$data->ready][0] ?>"></span>
            <div>
                <span class="label label-primary"><?= 'Создано: '.$data->date ?></span>
                <span class="label label-success"><?= 'Тип: '.$data->typeArr[$data->type] ?></span>
                <span class="label label-warning"><?= 'Статус: '.$data->statusArr[$data->status] ?></span>
                <span class="label label-warning"><?= 'Тип контакта: '.$data->cameFromArr[$data->cameFrom] ?></span>
                <span class="label label-default"><?= 'Менеджер: '.$managers[$data->managerId]['managerName'] ?></span>
                <span class="label label-danger"><?= ($data->callBack) ? 'Перезвонить: '.$data->callBack : '' ?></span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="btn-group btn-group-sm pull-right margin-top-12">
                <a class="btn btn-primary" href="<?= Url::to(['/helper/notebook/view', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
                <a class="btn btn-warning" href="<?= Url::to(['/helper/notebook/edit', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="btn btn-danger" href="<?= Url::to(['/helper/notebook/remove', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<? endforeach ?>