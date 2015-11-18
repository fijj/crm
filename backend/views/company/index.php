<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/* @var $this yii\web\View */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well clearfix">
    <div class="col-lg-12">
        <a class="btn btn-success pull-right" href="<?= Url::to(['/company/new']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?= GridView::widget([
            'id' => 'notebook-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table  table-bordered table-hover'],
            'columns' => [
                [
                    'attribute' => 'shortName',
                    'format' => 'html',
                    'value' => function($data){
                            return Html::a($data->shortName, ['company/view', 'id' => $data->id]);
                        }
                ],
                [
                    'attribute' => 'companyParam1',
                    'value' => function($data){
                            return $data->typeArr[$data->companyParam1];
                        },
                    'filter' => $searchModel->typeArr
                ],
                [
                    'attribute' => 'city',
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
