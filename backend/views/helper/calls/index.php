<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Звонки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Сегодня</h4></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Компания</th>
                        <th>Город</th>
                        <th>Телефон</th>
                        <th>Имя</th>
                    </tr>
                    </thead>
                    <? foreach ($today as $data): ?>
                        <tr>
                            <td><?= Html::tag('span', '', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color']]])?></td>
                            <td><?= Html::a($data->company, ['helper/notebook/view', 'id' => $data->id]) ?></td>
                            <td><?= $data->city ?></td>
                            <td><?= $data->phone ?></td>
                            <td><?= $data->firstName.' '.$data->secondName.' '.$data->thirdName ?></td>
                        </tr>
                    <? endforeach ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Завтра</h4></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Компания</th>
                        <th>Город</th>
                        <th>Телефон</th>
                        <th>Имя</th>
                    </tr>
                    </thead>
                    <? foreach ($tomorrow as $data): ?>
                        <tr>
                            <td><?= Html::tag('span', '', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color']]])?></td>
                            <td><?= Html::a($data->company, ['helper/notebook/view', 'id' => $data->id]) ?></td>
                            <td><?= $data->city ?></td>
                            <td><?= $data->phone ?></td>
                            <td><?= $data->firstName.' '.$data->secondName.' '.$data->thirdName ?></td>
                        </tr>
                    <? endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Неделя</h4></div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <? $last = '' ?>
                    <? foreach ($week as $data): ?>
                        <? if ($data->callBack != $last): ?>
                            <tr>
                                <td><b><?= Yii::$app->formatter->asDatetime($data->callBack, "php:d-m-Y") ?></b></td>
                            </tr>
                            <tr>
                                <td>
                                    <?= Html::tag('span', '', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color'], 'margin' => '0px 10px 0px 30px']])?>
                                    <?= Html::a($data->company, ['helper/notebook/view', 'id' => $data->id]) ?>
                                </td>
                            </tr>
                        <? else: ?>
                            <tr>
                                <td>
                                    <?= Html::tag('span', '', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color'], 'margin' => '0px 10px 0px 30px']])?>
                                    <?= Html::a($data->company, ['helper/notebook/view', 'id' => $data->id]) ?>
                                </td>
                            </tr>
                        <? endif ?>
                        <? $last = $data->callBack ?>
                    <? endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Пропущенные</h4></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th></th>
                        <th>Компания</th>
                        <th>Город</th>
                        <th>Телефон</th>
                        <th>Имя</th>
                    </tr>
                    </thead>
                    <? foreach ($missed as $data): ?>
                        <tr>
                            <td><?= Yii::$app->formatter->asDatetime($data->callBack, "php:d-m-Y") ?></td>
                            <td><?= Html::tag('span', '', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color']]])?></td>
                            <td><?= Html::a($data->company, ['helper/notebook/view', 'id' => $data->id]) ?></td>
                            <td><?= $data->city ?></td>
                            <td><?= $data->phone ?></td>
                            <td><?= $data->firstName.' '.$data->secondName.' '.$data->thirdName ?></td>
                        </tr>
                    <? endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>