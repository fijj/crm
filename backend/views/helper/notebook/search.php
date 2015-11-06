<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Поиск';
$this->params['breadcrumbs'][] = [
    'label' => 'Записная книжка',
    'url' => Url::to(['/helper/notebook/index']),
];
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
        <?= Html::input('','text','',['class' => 'form-control']) ?>
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary pull-left']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-6">
        <a class="btn btn-success pull-right" href="<?= Url::to(['/helper/notebook/new']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <? foreach ($model as $data): ?>
                    <? if($data->notebookId != $lastId):?>
                        <a class="link-name" href="<?= Url::toRoute(['/helper/notebook/view', 'id' => $data->notebook->id]); ?>"><?= $notebook[$data->notebookId]['company'] ?></a>
                    <? endif ?>
                    <ul>
                        <? if($data->date != $lastdate):?>
                            <h5>
                                <span class="label label-primary"><?= $data->date ?></span>
                            </h5>
                            <li><span class="label label-info"><?= $data->time ?></span>&nbsp;<?= $data->text ?></li>
                        <? else: ?>
                            <li><span class="label label-info"><?= $data->time ?></span>&nbsp;<?= $data->text ?></li>
                        <? endif; ?>
                        <? $lastdate = $data->date ?>
                    </ul>
                <? $lastId = $data->notebookId ?>
                <? endforeach ?>
            </div>
        </div>
    </div>
</div>