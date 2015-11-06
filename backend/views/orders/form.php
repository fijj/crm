<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => Url::to(['/company/index'])];
$this->params['breadcrumbs'][] = ['label' => $company->shortName, 'url' => Url::to(['/company/view', 'id' => $company->id])];
if($action == "update"){
    $this->params['breadcrumbs'][] = ['label' =>'Счет №'.$modelOrders->orderNum, 'url' => Url::to(['/orders/view', 'id' => $modelOrders->id])];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<?
$form = ActiveForm::begin([
    'id' => 'order-form',
    'enableClientValidation' => false,
]);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Счет</h4>
                </div>
                <div class="panel-body">
                    <div class="col-lg-2">
                        <?= $form->field($modelOrders, 'expire')->input('text', ['class' => 'datepicker form-control']) ?>
                    </div>
                    <div class="col-lg-2 col-lg-offset-8">
                        <?= $form->field($modelOrders, 'total')->input('text', ['readonly' => '', 'data-name' => 'all-total', 'class' => 'form-inline form-control']) ?>
                        <?= $form->field($modelOrders, 'tax')->input('text', ['readonly' => '', 'data-name' => 'all-nds']) ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Товары</h4>
                </div>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper_goods', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 999, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsGoods[0],
                        'formId' => 'order-form',
                        'formFields' => [
                            'name',
                            'cost',
                            'quantity',
                            'unit',
                            'discount',
                            'tax',
                            'taxInclude',
                            'total',
                            'taxTotal'
                        ],
                    ]); ?>
                    <table class="container-items table order-table"><!-- widgetContainer -->
                        <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                                <th>Ед. измерения</th>
                                <th>Скидка</th>
                                <th>Налог</th>
                                <th>Включен в цену</th>
                                <th>Сумма налога</th>
                                <th>Итого</th>
                                <th><button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($modelsGoods as $i => $item): ?>
                            <tr class="item">
                                <?php
                                // necessary for update action.
                                if (! $item->isNewRecord) {
                                    echo Html::activeHiddenInput($item, "[{$i}]id");
                                }
                                ?>
                                <td>
                                    <?= $form->field($item, "[{$i}]name")->textarea(['placeholder' => 'Новый товар', 'class' => 'tinymce-2'])->label(false) ?>
                                </td>
                                <td style="width:120px">
                                    <?= $form->field($item, "[{$i}]cost")->input('',['placeholder' => '0.00', 'data-name' => 'cost'])->label(false) ?>
                                </td>
                                <td style="width:120px">
                                    <?= $form->field($item, "[{$i}]quantity")->input('int',['placeholder' => '0', 'data-name' => 'quantity'])->label(false) ?>
                                </td>
                                <td style="width:95px">
                                    <?= $form->field($item, "[{$i}]unit")->dropDownList($item->unitArr)->label(false) ?>
                                </td>
                                <td style="width:120px">
                                    <?= $form->field($item, "[{$i}]discount")->input('int',['placeholder' => '0.00', 'data-name' => 'discount'])->label(false) ?>
                                </td>
                                <td style="width:95px">
                                    <?= $form->field($item, "[{$i}]tax")->dropDownList($item->taxArr, ['data-name' => 'tax'])->label(false) ?>
                                </td>
                                <td style="width:20px">
                                    <?= $form->field($item, "[{$i}]taxInclude")->checkbox(['label' => '', 'data-name' => 'taxInclude']) ?>
                                </td>
                                <td style="width:120px">
                                    <?= $form->field($item, "[{$i}]taxTotal")->input('int',['placeholder' => '0.00', 'data-name' => 'tax-total'])->label(false) ?>
                                </td>
                                <td style="width:120px">
                                    <?= $form->field($item, "[{$i}]total")->input('int',['placeholder' => '0.00', 'data-name' => 'total'])->label(false) ?>
                                </td>
                                <td>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>
