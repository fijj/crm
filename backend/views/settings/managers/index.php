<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Менеджеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <a class="btn btn-success pull-right" href="<?= Url::to(['settings/managers/new']) ?>">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<? foreach ($model as $data): ?>
<div class="panel panel-default">
    <div class="panel-body">
        <a class="link-name" href="<?= Url::toRoute(['settings/managers/edit', 'id' => $data->id]); ?>"><?= $data->managerName ?></a>
        <div class="btn-group btn-group-sm pull-right">
            <!--
            <a class="btn btn-primary" href="<?= Url::to(['settings/managers/view', 'id' => $data->id]) ?>">
                <span class="glyphicon glyphicon-eye-open"></span>
            </a>
            !-->
            <a class="btn btn-warning" href="<?= Url::to(['settings/managers/edit', 'id' => $data->id]) ?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <? if ($data->id !=1): ?>
                <a class="btn btn-danger" href="<?= Url::to(['settings/managers/remove', 'id' => $data->id]) ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <? endif ?>
        </div>
    </div>
</div>
<? endforeach ?>

