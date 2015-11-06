<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Orders;
use backend\models\Purchasing;
use backend\models\Delivery;

/* @var $this yii\web\View */

$this->title = 'Счет №' . $orders->orderNum;
$this->params['breadcrumbs'][] = [
    'label' => 'Счета',
    'url' => Url::to(['/orders/index']),
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?
$form = ActiveForm::begin([
    'id' => 'order-form',
    'options' => ['enctype'=>'multipart/form-data']
]);
?>

    <div class="well clearfix">
        <div class="btn-group btn-group-sm pull-right">
            <a class="btn btn-default" href="<?= Url::to(['/orders/preview', 'id' => $orders->id]) ?>" target="_blank">Предварительный просмотр</a>
            <a class="btn btn-primary" href="<?= Url::to(['/orders/generate', 'id' => $orders->id]) ?>">Создать файл счета</a>
            <a class="btn btn-warning" href="<?= Url::to(['/orders/edit', 'id' => $orders->id]) ?>">Редактировать</a>
            <a class="btn btn-danger" href="<?= Url::to(['/orders/remove', 'id' => $orders->id]) ?>">Удалить</a>
        </div>
    </div>
    <h3>Счет №<?= $orders->orderNum ?></h3>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Счет</div>
                <div class="panel-body">
                    <p><b>Номер счета: </b>
                        <mark><?= $orders->orderNum; ?></mark>
                    </p>
                    <p><b>Дата выставления: </b>
                        <mark><?= $orders->date; ?></mark>
                    </p>
                    <p><b>Дата окончания: </b>
                        <mark><?= $orders->expire; ?></mark>
                    </p>
                </div>
                <div class="panel-heading">Оплата</div>
                <div class="panel-body">
                    <p>
                        <b>Оплачено: </b>
                        <mark><?= $paymentsBar['total']; ?></mark>
                        <b>Полная стоимость: </b>
                        <mark><?= $orders->total; ?></mark>
                        <b>В том числе НДС: </b>
                        <mark><?= $orders->tax; ?></mark>
                    </p>
                    <br/>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                             style="width: <?= $paymentsBar['percent'] ?>%;">
                            <?= $paymentsBar['percent'] ?>%
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-3">
                            <?= $form->field($orders, 'status')->dropDownList($orders->statusLabel, ['class' => 'form-control']) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($orders, 'dateOfSale')->input('date', ['class' => 'form-control datepicker']) ?>
                        </div>
                    </div>
                    <hr/>
                    <p><b>Документы</b></p>
                    <table class="table order-table"><!-- widgetContainer -->
                        <thead>
                        <tr>
                            <th></th>
                            <th>Номер</th>
                            <th>Файл</th>
                            <th>Скан</th>
                            <th>Отправлен</th>
                            <th>Получен</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Товарная накладная</td>
                            <td>
                                <?= $form->field($orders, 'docNum1')->label(false) ?>
                            </td>
                            <td>
                                <? if($orders->docFile1 != ''){
                                    echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$orders->docFile1", ['target' => '_blank']);
                                    echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile1', 'class' => 'Orders']), ['class' => 'order-file-delete confirm-msg']);
                                }else{
                                    echo $form->field($orders, 'docFile1')->fileInput()->label(false);
                                }
                                ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docScan1')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docSend1')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docRecive1')->checkbox(['label' => '']) ?>
                            </td>
                        </tr>
                        <? if($orders->tax > 0): ?>
                            <tr>
                                <td>Счет фактура</td>
                                <td>
                                    <?= $form->field($orders, 'docNum2')->label(false) ?>
                                </td>
                                <td>
                                    <? if($orders->docFile2 != ''){
                                        echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$orders->docFile2", ['target' => '_blank']);
                                        echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile2', 'class' => 'Orders']), ['class' => 'order-file-delete confirm-msg']);
                                    }else{
                                        echo $form->field($orders, 'docFile2')->fileInput()->label(false);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= $form->field($orders, 'docScan2')->checkbox(['label' => '']) ?>
                                </td>
                                <td>
                                    <?= $form->field($orders, 'docSend2')->checkbox(['label' => '']) ?>
                                </td>
                                <td>
                                    <?= $form->field($orders, 'docRecive2')->checkbox(['label' => '']) ?>
                                </td>
                            </tr>
                        <? endif ?>
                        <tr>
                            <td>Договор</td>
                            <td>
                                <?= $form->field($orders, 'docNum3')->label(false) ?>
                            </td>
                            <td>
                                <? if($orders->docFile3 != ''){
                                    echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$orders->docFile3", ['target' => '_blank']);
                                    echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile3', 'class' => 'Orders']), ['class' => 'order-file-delete confirm-msg']);
                                }else{
                                    echo $form->field($orders, 'docFile3')->fileInput()->label(false);
                                }
                                ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docScan3')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docSend3')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docRecive3')->checkbox(['label' => '']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Счет</td>
                            <td>
                                <?= $form->field($orders, 'docNum4')->label(false) ?>
                            </td>
                            <td>
                                <? if($orders->docFile4 != ''){
                                    echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$orders->docFile4", ['target' => '_blank']);
                                    echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile4', 'class' => 'Orders']), ['class' => 'order-file-delete confirm-msg']);
                                }else{
                                    echo $form->field($orders, 'docFile4')->fileInput()->label(false);
                                }
                                ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docScan4')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docSend4')->checkbox(['label' => '']) ?>
                            </td>
                            <td>
                                <?= $form->field($orders, 'docRecive4')->checkbox(['label' => '']) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <hr/>
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($orders, 'deliveryDate')->input('text', ['class' => 'datepicker form-control']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <b>Осталось дней:</b>
                        </div>
                        <div class="col-lg-10">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                     aria-valuemax="100" style="width: 60%;">
                                    <?= $deliveryDate ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper_payments', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-payments', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 999, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-payments', // css class
                        'deleteButton' => '.remove-payments', // css class
                        'model' => $payments[0],
                        'formId' => 'order-form',
                        'formFields' => [
                            'status',
                            'date',
                            'sum',
                            'installment'
                        ],
                    ]); ?>

                    <hr/>
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($orders, 'installment')->dropDownList($orders->installmentLabel) ?>
                        </div>
                    </div>
                    <p><b>График платежей</b></p>
                    <table class="container-payments table order-table"><!-- widgetContainer -->
                        <thead>
                        <tr>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>
                                <button type="button" class="add-payments btn btn-success btn-xs"><i
                                        class="glyphicon glyphicon-plus"></i></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($payments as $i => $item): ?>
                            <tr class="item">
                                <?php
                                // necessary for update action.
                                if (!$item->isNewRecord) {
                                    echo Html::activeHiddenInput($item, "[{$i}]id");
                                }
                                ?>
                                <td>
                                    <?= $form->field($item, "[{$i}]status")->checkbox(['label' => ''])->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($item, "[{$i}]date")->input('date', ['class' => 'datepicker form-control'])->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($item, "[{$i}]sum")->input('', ['placeholder' => '0.00', 'data-name' => 'cost'])->label(false) ?>
                                </td>
                                <td>
                                    <button type="button" class="remove-payments btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">Гарантия</div>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper_warranty', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-warranty', // required: css class selector
                        'widgetItem' => '.warranty', // required: css class
                        'limit' => 999, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-warranty', // css class
                        'deleteButton' => '.remove-warranty', // css class
                        'model' => $warranty[0],
                        'formId' => 'order-form',
                        'formFields' => [
                            'name',
                            'date'
                        ],
                    ]); ?>

                    <hr/>
                    <table class="container-warranty table order-table"><!-- widgetContainer -->
                        <thead>
                        <tr>
                            <th>Номенклатура</th>
                            <th>Дата</th>
                            <th>
                                <button type="button" class="add-warranty btn btn-success btn-xs"><i
                                        class="glyphicon glyphicon-plus"></i></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($warranty as $i => $item): ?>
                            <tr class="warranty">
                                <?php
                                // necessary for update action.
                                if (!$item->isNewRecord) {
                                    echo Html::activeHiddenInput($item, "[{$i}]id");
                                }
                                ?>
                                <td>
                                    <?= $form->field($item, "[{$i}]name")->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($item, "[{$i}]date")->input('date', ['class' => 'datepicker form-control'])->label(false) ?>
                                </td>
                                <td>
                                    <button type="button" class="remove-warranty btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
            <?= $form->field($orders, 'delivery')->dropDownList($orders->whoDeliveryLabel) ?>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_delivery', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-delivery', // required: css class selector
                'widgetItem' => '.delivery', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-delivery', // css class
                'deleteButton' => '.remove-delivery', // css class
                'model' => $delivery[0],
                'formId' => 'order-form',
                'formFields' => [
                    'name',
                    'tracking',
                    'status',
                    'docNum1',
                    'docNum2',
                    'docFile1',
                    'docFile2',
                    'docScan1',
                    'docScan2',
                    'docOrig1',
                    'docOrig2',
                    'cost'
                ],
            ]); ?>

            <div class="container-delivery">
                <?php foreach ($delivery as $i => $item): ?>

                    <div class="panel panel-danger delivery">
                        <?php
                        // necessary for update action.
                        if (!$item->isNewRecord) {
                            echo Html::activeHiddenInput($item, "[{$i}]id");
                        }
                        ?>
                        <div class="panel-heading">
                            Доставка
                            <button type="button" class="remove-delivery btn btn-danger btn-xs pull-right"><i
                                    class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-3">
                                <?= $form->field($item, "[{$i}]name") ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($item, "[{$i}]tracking") ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($item, "[{$i}]cost")->input('integer', ['placeholder' => '0.00']) ?>
                            </div>
                            <div class="col-lg-3">
                                <?= $form->field($item, "[{$i}]status")->dropDownList($item->statusLabel) ?>
                            </div>
                            <hr/>
                            <p><b>Документы</b></p>
                            <table class="table order-table"><!-- widgetContainer -->
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Номер</th>
                                    <th>Файл</th>
                                    <th>Скан</th>
                                    <th>Оригинал</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Товарная накладная</td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docNum1")->label(false) ?>
                                    </td>
                                    <td>
                                        <? if($item->docFile1 != ''){
                                            echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile1", ['target' => '_blank', 'class' => 'order-file-link']);
                                            echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile1', 'class' => 'Delivery']), ['class' => 'order-file-delete confirm-msg']);
                                            echo $form->field($item, "[{$i}]docFile1")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                        }else{
                                            echo $form->field($item, "[{$i}]docFile1")->fileInput()->label(false);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docScan1")->checkbox(['label' => '']) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docOrig1")->checkbox(['label' => '']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Счет фактура</td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docNum2")->label(false) ?>
                                    </td>
                                    <td>
                                        <? if($item->docFile2 != ''){
                                            echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile2", ['target' => '_blank', 'class' => 'order-file-link']);
                                            echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile2', 'class' => 'Delivery']), ['class' => 'order-file-delete confirm-msg']);
                                            echo $form->field($item, "[{$i}]docFile2")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                        }else{
                                            echo $form->field($item, "[{$i}]docFile2")->fileInput()->label(false);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docScan2")->checkbox(['label' => '']) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$i}]docOrig2")->checkbox(['label' => '']) ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button style="display: block; width: 100%" type="button" class="add-delivery btn btn-success btn-xs"><i class="glyphicon glyphicon-plus">Добавить доставку</i></button>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_purchasing', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-purchasing', // required: css class selector
                'widgetItem' => '.purchasing', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-purchasing', // css class
                'deleteButton' => '.remove-purchasing', // css class
                'model' => $purchasing[0],
                'formId' => 'order-form',
                'formFields' => [
                    'orderNum',
                    'date',
                    'file',
                    'paid',
                    'total',
                    'tax',
                    'status',
                    'docNum1',
                    'docNum2',
                    'docNum3',
                    'docNum4',
                    'docFile1',
                    'docFile2',
                    'docFile3',
                    'docFile4',
                    'docScan1',
                    'docScan2',
                    'docScan3',
                    'docScan4',
                    'docOrig1',
                    'docOrig2',
                    'docOrig3',
                    'docOrig4',
                    'comment'
                ],
            ]); ?>

            <div class="col-lg-6">
                <div class="container-purchasing">
                    <?php foreach ($purchasing as $i => $item): ?>
                        <div class="panel panel-success purchasing">
                            <?php
                            // necessary for update action.
                            if (!$item->isNewRecord) {
                                echo Html::activeHiddenInput($item, "[{$i}]id");
                            }
                            ?>
                            <div class="panel-heading">
                                Счет
                                <button type="button" class="remove-purchasing btn btn-danger btn-xs pull-right"><i
                                        class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-6">
                                    <?= $form->field($item, "[{$i}]orderNum") ?>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($item, "[{$i}]date")->input('date', ['class' => 'datepicker form-control']) ?>
                                </div>
                            </div>
                            <div class="panel-heading">Оплата</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?= $form->field($item, "[{$i}]paid")->input('integer', ['placeholder' => '0.00']) ?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?= $form->field($item, "[{$i}]total")->input('integer', ['placeholder' => '0.00']) ?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?= $form->field($item, "[{$i}]tax")->input('integer', ['placeholder' => '0.00']) ?>
                                    </div>
                                </div>
                                <br/>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100" style="width: <?= $item->paymentsBar() ?>%;">
                                         <?= $item->paymentsBar() ?>%
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($item, "[{$i}]status")->dropDownList($item->statusLabel, ['class' => 'form-control']) ?>
                                    </div>
                                </div>
                                <hr/>
                                <p><b>Документы</b></p>
                                <table class="table order-table"><!-- widgetContainer -->
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Номер</th>
                                        <th>Файл</th>
                                        <th>Скан</th>
                                        <th>Оригинал</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Товарная накладная</td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docNum1")->label(false) ?>
                                        </td>
                                        <td>
                                            <? if($item->docFile1 != ''){
                                                echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile1", ['target' => '_blank', 'class' => 'order-file-link']);
                                                echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile1', 'class' => 'Purchasing']), ['class' => 'order-file-delete confirm-msg']);
                                                echo $form->field($item, "[{$i}]docFile1")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                            }else{
                                                echo $form->field($item, "[{$i}]docFile1")->fileInput()->label(false);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docScan1")->checkbox(['label' => '']) ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docOrig1")->checkbox(['label' => '']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Счет фактура</td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docNum2")->label(false) ?>
                                        </td>
                                        <td>
                                            <? if($item->docFile2 != ''){
                                                echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile2", ['target' => '_blank', 'class' => 'order-file-link']);
                                                echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile2', 'class' => 'Purchasing']), ['class' => 'order-file-delete confirm-msg']);
                                                echo $form->field($item, "[{$i}]docFile2")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                            }else{
                                                echo $form->field($item, "[{$i}]docFile2")->fileInput()->label(false);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docScan2")->checkbox(['label' => '']) ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docOrig2")->checkbox(['label' => '']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Договор</td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docNum3")->label(false) ?>
                                        </td>
                                        <td>
                                            <? if($item->docFile3 != ''){
                                                echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile3", ['target' => '_blank', 'class' => 'order-file-link']);
                                                echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile3', 'class' => 'Purchasing']), ['class' => 'order-file-delete confirm-msg']);
                                                echo $form->field($item, "[{$i}]docFile3")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                            }else{
                                                echo $form->field($item, "[{$i}]docFile3")->fileInput()->label(false);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docScan3")->checkbox(['label' => '']) ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docOrig3")->checkbox(['label' => '']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Счет</td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docNum4")->label(false) ?>
                                        </td>
                                        <td>
                                            <? if($item->docFile4 != ''){
                                                echo Html::a('Смотреть файл', "uploads/orders/$orders->dir/$item->dir/$item->docFile4", ['target' => '_blank', 'class' => 'order-file-link']);
                                                echo Html::a('<i class=" glyphicon glyphicon-remove"></i>', Url::to(['orders/remove-file', 'id' => $orders->id, 'file' => 'docFile4', 'class' => 'Purchasing']), ['class' => 'order-file-delete confirm-msg']);
                                                echo $form->field($item, "[{$i}]docFile4")->fileInput(['class' => 'order-file-input hidden'])->label(false);
                                            }else{
                                                echo $form->field($item, "[{$i}]docFile4")->fileInput()->label(false);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docScan4")->checkbox(['label' => '']) ?>
                                        </td>
                                        <td>
                                            <?= $form->field($item, "[{$i}]docOrig4")->checkbox(['label' => '']) ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $form->field($item, "[{$i}]comment")->textarea() ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button style="display: block; width: 100%" type="button" class="add-purchasing btn btn-success btn-xs">
                            <i class="glyphicon glyphicon-plus">Добавить</i></button>
                    </div>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
        </div><!-- main panel body -->
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $form->field($orders, 'comment')->textarea() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div> <!-- main panel -->

<?php ActiveForm::end() ?>