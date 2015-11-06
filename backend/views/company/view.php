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
                <a class="btn btn-warning" href="<?= Url::to(['/company/edit', 'id' => $model->id]) ?>">Редактировать</a>
                <a class="btn btn-danger" href="<?= Url::to(['/company/remove', 'id' => $model->id]) ?>">Удалить</a>
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
                            <td><?= $model->getAttributeLabel('fullName') ?></td>
                            <td><?= $model->fullName ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('shortName'); ?></td>
                            <td><?= $model->shortName ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('city'); ?></td>
                            <td><?= $model->city ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam2'); ?></td>
                            <td><?= $model->companyParam2 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam3'); ?></td>
                            <td><?= $model->companyParam3 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam4'); ?></td>
                            <td><?= $model->companyParam4 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam5'); ?></td>
                            <td><?= $model->companyParam5 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam6'); ?></td>
                            <td><?= $model->companyParam6 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam7'); ?></td>
                            <td><?= $model->companyParam7 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam8'); ?></td>
                            <td><?= $model->companyParam8 ?></td>
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
                            <td><?= $model->getAttributeLabel('companyParam9'); ?></td>
                            <td><?= $model->companyParam9 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam10'); ?></td>
                            <td><?= $model->companyParam10 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam11'); ?></td>
                            <td><?= $model->companyParam11 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam12'); ?></td>
                            <td><?= $model->companyParam12 ?></td>
                        </tr>
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
                            <td><?= $model->getAttributeLabel('companyParam13'); ?></td>
                            <td><?= $model->companyParam13 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam14'); ?></td>
                            <td><?= $model->companyParam14 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam15'); ?></td>
                            <td><?= $model->companyParam15 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam16'); ?></td>
                            <td><?= $model->companyParam16 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam17'); ?></td>
                            <td><?= $model->companyParam17 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam18'); ?></td>
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
                            <td><?= $model->getAttributeLabel('companyParam20'); ?></td>
                            <td><?= $model->companyParam20 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam21'); ?></td>
                            <td><?= $model->companyParam21 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam22'); ?></td>
                            <td><?= $model->companyParam22 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam23'); ?></td>
                            <td><?= $model->companyParam23 ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('companyParam24'); ?></td>
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
                            <td><?= $model->getAttributeLabel('email'); ?></td>
                            <td><?= $model->email ?></td>
                        </tr>
                        <tr>
                            <td><?= $model->getAttributeLabel('password'); ?></td>
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
                                <td><?= $manager->getAttributeLabel('managerName'); ?></td>
                                <td><?= $manager->managerName ?></td>
                            </tr>
                            <tr>
                                <td><?= $manager->getAttributeLabel('managerPhone'); ?></td>
                                <td><?= $manager->managerPhone ?></td>
                            </tr>
                            <tr>
                                <td><?= $manager->getAttributeLabel('email'); ?></td>
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