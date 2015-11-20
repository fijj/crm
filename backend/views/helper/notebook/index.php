<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$this->title = 'Записная книжка';
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
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        <?= Html::input('','text','',['class' => 'form-control']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-6">
        <a class="btn btn-success pull-right" href="<?= Url::to(['/helper/notebook/new']) ?>">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
<?= GridView::widget([
    'id' => 'notebook-grid',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
    'columns' => [
        [
            'attribute' => 'ready',
            'filter' => $searchModel->readyLabelArr,
            'format' => 'html',
            'options' => ['style' => 'width: 100px'],
            'contentOptions' => ['style' => 'text-align:center'],
            'label' => 'Готовность',
            'value' => function($data){
                    return Html::beginTag('span', ['class' => 'company-temp', 'style' => ['background-color' => $data->readyArr[$data->ready]['color']]]);
                }
        ],
        [
            'attribute' => 'company',
            'format' => 'html',
            'value' => function($data){
                    return Html::a($data->company, ['helper/notebook/update', 'id' => $data->id]);
                }
        ],
        [
            'attribute' => 'city',
            'options' => ['style' => 'width: 200px'],
        ],
        [
            'attribute' => 'date',
            'label' => 'Дата',
            'options' => ['style' => 'width: 100px'],
        ],
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'options' => ['style' => 'width: 150px'],
            'contentOptions' => ['style' => 'color: #C0C0C0'],
            'value' => function($data){
                    if($data->firstName || $data->secondName || $data->thirdName){
                        return Html::tag('div', $data->phone, [
                            'title' => $data->firstName.' '. $data->secondName.' '. $data->thirdName,
                            'data-toggle' => 'tooltip',
                            'style' => 'color: #000; cursor:pointer;'
                        ]);
                    }else{
                        return $data->phone;
                    }
                }

        ],
        [
            'attribute' => 'email',
        ],
        [
            'attribute' => 'type',
            'filter' => $searchModel->typeArr,
            'value' => function($data){
                    return $data->typeArr[$data->type];
                },
            'options' => ['style' => 'width: 100px'],
        ],
        [
            'attribute' => 'status',
            'filter' => $searchModel->statusArr,
            'value' => function($data){
                    return $data->statusArr[$data->status];
                },
            'options' => ['style' => 'width: 150px'],
        ],
        [
            'attribute' => 'managerId',
            'value' => 'managers.firstName',
            'options' => ['style' => 'width: 150px'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model) {

                    },
            ],
        ]
    ]
]); ?>