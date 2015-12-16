<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\jui\DatePicker;
/* @var $this yii\web\View */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <?= GridView::widget([
            'id' => 'notebook-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table  table-bordered table-hover'],
            'rowOptions' => function ($data){
                    if($data->status == 3){
                        return ['style' => ['opacity' => '0.2']];
                    }
                },
            'columns' => [
                [
                    'attribute' => 'orderNum',
                    'format' => 'html',
                    'value' => function($data){
                            return Html::a($data->orderNum, ['orders/view', 'id' => $data->id]);
                        },
                ],
                [
                    'attribute' => 'date',
                    'filter' => \yii\jui\DatePicker::widget([
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                            'model' => $searchModel,
                            'attribute' => 'date',
                            'options' =>[
                                'class' => 'form-control'
                            ]
                        ]),
                ],
                [
                    'attribute' => 'companyId',
                    'value' => 'company.shortName'
                ],
                [
                    'attribute' => 'status',
                    'value' => function($data){
                            return $data->statusLabel[$data->status];
                        },
                    'filter' => $searchModel->statusLabel,
                ],
                [
                    'attribute' => 'expire',
                    'filter' => \yii\jui\DatePicker::widget([
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                            'model' => $searchModel,
                            'attribute' => 'expire',
                            'options' =>[
                                'class' => 'form-control'
                            ]
                        ]),
                ],
                [
                    'format' => 'decimal',
                    'attribute' => 'total',
                ],
                [
                    'format' => 'decimal',
                    'attribute' => 'profit',
                ],
                [
                    'attribute' => 'managerId',
                    'value' => 'managers.firstName'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                ],
            ]
        ]); ?>
    </div>
</div>