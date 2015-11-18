<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
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
            'columns' => [
                [
                    'attribute' => 'orderNum',
                ],
                [
                    'attribute' => 'date',
                    'filter' => \yii\jui\DatePicker::widget(\yii\jui\DatePicker::className(), ['language' => 'ru', 'dateFormat' => 'dd-MM-yyyy'])
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
                    'filter' => $searchModel->statusLabel
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                ],
            ]
        ]); ?>
    </div>
</div>