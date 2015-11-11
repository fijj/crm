<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <div class="col-lg-12">
        <a class="btn btn-success pull-right" href="<?= Url::to(['/company/new']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="sort-container">
            <span class="label label-primary"><?= $sort->link('id') ?></span>
            <span class="label label-primary"><?= $sort->link('fullName') ?></span>
            <span class="label label-primary"><?= $sort->link('managerId') ?></span>
            <span class="label label-primary"><?= $sort->link('companyParam1') ?></span>
        </div>
    </div>
</div>
<? foreach ($model as $data): ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-8">
            <a class="link-name" href="<?= Url::toRoute(['company/view', 'id' => $data->id]); ?>"><?= $data->fullName ?></a>
            <div>
                <span class="label label-success"><?= 'Тип: '.$type[$data->companyParam1] ?></span>
                <span class="label label-default"><?= 'Менеджер: '.$managers[$data->managerId]['firstName'] ?></span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="btn-group btn-group-sm pull-right margin-top-12">
                <a class="btn btn-primary" href="<?= Url::to(['/company/view', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </a>
                <a class="btn btn-warning" href="<?= Url::to(['/company/edit', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="btn btn-danger" href="<?= Url::to(['/company/remove', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<? endforeach ?>