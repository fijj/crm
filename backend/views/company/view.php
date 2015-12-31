<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = [
    'label' => 'Компании',
    'url' => Url::to(['/company/index']),
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <div class="col-lg-12">
        <div class="btn-group btn-group-sm pull-right">
                <a class="btn btn-default" href="<?= Url::to(['/orders/new', 'id' => $model->id]) ?>">Создать счет</a>
                <a class="btn btn-default" href="<?= Url::to(['/company/new']) ?>">Создать</a>
                <a class="btn btn-warning" href="<?= Url::to(['/company/update', 'id' => $model->id]) ?>">Редактировать</a>
                <a class="btn btn-danger" href="<?= Url::to(['/company/delete', 'id' => $model->id]) ?>">Удалить</a>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-heading">
            <h4>
                <?= $model->fullName ?>
                <? if($model->companyParam1 === 0): ?>
                    <span class="label label-success">частная</span>
                <? elseif($model->companyParam1 === 1): ?>
                    <span class="label label-success">государственная</span>
                <? endif ?>
            </h4>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Карточка предприятия</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b><?= $model->getAttributeLabel('fullName') ?></b></td>
                            <td><?= $model->fullName ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('shortName'); ?></b></td>
                            <td><?= $model->shortName ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('city'); ?></b></td>
                            <td><?= $model->city ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam2'); ?></b></td>
                            <td><?= $model->companyParam2 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam3'); ?></b></td>
                            <td><?= $model->companyParam3 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam4'); ?></b></td>
                            <td><?= $model->companyParam4 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam5'); ?></b></td>
                            <td><?= $model->companyParam5 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam6'); ?></b></td>
                            <td><?= $model->companyParam6 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam7'); ?></b></td>
                            <td><?= $model->companyParam7 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam8'); ?></b></td>
                            <td><?= $model->companyParam8 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam10'); ?></b></td>
                            <td><?= $model->companyParam10 ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Банковские реквезиты</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam9'); ?></b></td>
                            <td><?= $model->companyParam9 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam11'); ?></b></td>
                            <td><?= $model->companyParam11 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam12'); ?></b></td>
                            <td><?= $model->companyParam12 ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Счета</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <thead>
                            <th>Номер</th>
                            <th>Дата</th>
                            <th>Истекает</th>
                            <th>Статус</th>
                            <th>Итого</th>
                            <th>Оплатили</th>
                        </thead>
                        <? foreach($model->orders as $order): ?>
                            <tbody>
                                <tr class="order-head-row">
                                    <td><?= Html::a($order->orderNum, ['orders/view', 'id' => $order->id])?></td>
                                    <td><?= $order->date ?></td>
                                    <td><?= $order->expire ?></td>
                                    <td><?= $order->statusLabel[$order->status] ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal($order->total, 2) ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal($order->payments(), 2) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <table class="table table-condensed table-hover order-goods-table">
                                        <? foreach ($order->goods() as $good): ?>
                                            <tr class="order-goods-row">
                                                <td colspan><?= $good->name ?></td>
                                                <td><?= $good->quantity ?></td>
                                                <td><?= Yii::$app->formatter->asDecimal($good->total, 2) ?></td>
                                            </tr>
                                            <? endforeach ?>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        <? endforeach ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Руководитель или контактное лицо</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam13'); ?></b></td>
                            <td><?= $model->companyParam13 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam14'); ?></b></td>
                            <td><?= $model->companyParam14 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam15'); ?></b></td>
                            <td><?= $model->companyParam15 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam16'); ?></b></td>
                            <td><?= $model->companyParam16 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam17'); ?></b></td>
                            <td><?= $model->companyParam17 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam18'); ?></b></td>
                            <td><?= $model->companyParam18 ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Главный бухгалтер</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam20'); ?></b></td>
                            <td><?= $model->companyParam20 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam21'); ?></b></td>
                            <td><?= $model->companyParam21 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam22'); ?></b></td>
                            <td><?= $model->companyParam22 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam23'); ?></b></td>
                            <td><?= $model->companyParam23 ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('companyParam24'); ?></b</td>
                            <td><?= $model->companyParam24 ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Учетная запись</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td><b><?= $model->getAttributeLabel('email'); ?></b></td>
                            <td><?= $model->email ?></td>
                        </tr>
                        <tr>
                            <td><b><?= $model->getAttributeLabel('password'); ?></b></td>
                            <td><?= $model->password ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <? if ($manager):?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Персональный менеджер</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <td><b><?= $manager->getAttributeLabel('fullName'); ?></b></td>
                                <td><?= $manager->fullName ?></td>
                            </tr>
                            <tr>
                                <td><b><?= $manager->getAttributeLabel('managerPhone'); ?></b></td>
                                <td><?= $manager->managerPhone ?></td>
                            </tr>
                            <tr>
                                <td><b><?= $manager->getAttributeLabel('email'); ?></b></td>
                                <td><?= $manager->email ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img width="100%" src="uploads/managers/<?= $manager->managerPhoto ?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <? endif ?>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Комментарий</h4>
                </div>
                <div class="panel-body">
                    <p><?= $model->companyParam19 ?></p>
                </div>
            </div>
        </div>
    </div>
</div>