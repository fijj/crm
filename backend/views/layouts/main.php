<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\models\settings\Managers;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="wrap">
<?php $this->beginBody() ?>
    <?php
    // получение коллекции кук
    $cookies = Yii::$app->request->cookies;

    NavBar::begin([
        'brandLabel' => 'Здравствуйте, '.Managers::findOne(Yii::$app->user->identity->managerId)->secondName,
        'options' => [
            'class' => 'first-nav',
        ],
        'innerContainerOptions' => ['class'=>'container-fluid'],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    ?>
    <? if ($cookies->has('mode')): ?>
        <div class="switch-container">
            <span class="switch-txt swt-active">CRM</span>
            <?= Html::a('', ['/site/unset-mode'], ['class' => 'switch-btn left']) ?>
            <span class="switch-txt">Документы</span>
        </div>
    <? else: ?>
        <div class="switch-container">
            <span class="switch-txt">CRM</span>
            <?= Html::a('', ['/site/set-mode'], ['class' => 'switch-btn right']) ?>
            <span class="switch-txt swt-active">Документы</span>
        </div>
    <? endif ?>

    <?
    NavBar::end();
    ?>

    <div class="middle-bar">
        <div class="container-fluid2">
            <img style="width:160px;" src="img/logo.png">
        </div>
    </div>
    <div class="second-nav-container">
        <?php
        NavBar::begin([
            'options' => [
                'class' => 'second-nav',
            ],
            'innerContainerOptions' => ['class'=>'container-fluid'],
        ]);
        $menuItems = [
            ['label' => 'Главная', 'url' => ['/site/index']],
        ];
        if (! Yii::$app->user->isGuest) {
            if ($cookies->has('mode')){
                $menuItems[] = ['label' => 'Записная книжка', 'url' => ['/helper/notebook/index']];
                $menuItems[] = ['label' => 'Звонки', 'url' => ['/helper/calls/index']];
            }else{
                $menuItems[] = ['label' => 'Компании', 'url' => ['/company/index'],];
                $menuItems[] = ['label' => 'Гарантия', 'url' => ['/warranty/index']];
                $menuItems[] = ['label' => 'Счета', 'url' => ['/orders/index']];
                $menuItems[] = ['label' => 'Настройки',
                    'items' =>[
                        ['label' => 'Реквизиты', 'url' => ['/settings/details/index']],
                        ['label' => 'Менеджеры', 'url' => ['/settings/managers/index']],
                    ],
                ];
            }
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    </div>
    <div class="main-body container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ОРОСМедикал <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>