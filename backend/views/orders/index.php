<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="sort-container">
                <span class="label label-primary"><?= $sort->link('id') ?></span>
                <span class="label label-primary"><?= $sort->link('companyId') ?></span>
                <span class="label label-primary"><?= $sort->link('managerId') ?></span>
                <span class="label label-primary"><?= $sort->link('expire') ?></span>
                <span class="label label-primary"><?= $sort->link('status') ?></span>
            </div>
        </div>
    </div>
<? foreach ($model as $data): ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-8">
            <a class="link-name" href="<?= Url::toRoute(['orders/view', 'id' => $data->id]); ?>">Счет №<?= $data->orderNum ?></a>
            <div>
                <span class="label label-success"><?= 'Компания: '.$data->company->shortName ?></span>
                <span class="label label-default"><?= 'Создан: '.$data->date ?></span>
                <span class="label label-warning"><?= 'Истекает: '.$data->expire ?></span>
                <span class="label label-warning"><?= 'Статус: '.$data->statusLabel[$data->status] ?></span>
                <span class="label label-primary"><?= 'Менеджер: '.$data->managers->firstName ?></span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="btn-group btn-group-sm pull-right margin-top-12">
                <a class="btn btn-primary" href="<?= Url::to(['/orders/view', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </a>
                <a class="btn btn-warning" href="<?= Url::to(['/orders/edit', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="btn btn-danger" href="<?= Url::to(['/orders/remove', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<? endforeach ?>