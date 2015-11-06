<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/classic.date.css',
        'css/classic.css',
        'css/site.css',
    ];
    public $js = [
        'js/tinymce/tinymce.min.js',
        'js/main.js',
        'js/pickdate/picker.js',
        'js/pickdate/picker.date.js',
        'js/pickdate/picker.time.js',
        'js/pickdate/legacy.js',
        'js/pickdate/translations/ru_RU.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
