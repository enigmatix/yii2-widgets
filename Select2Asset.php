<?php
/**
 * Created by PhpStorm.
 * User: Joel Small
 * Date: 13/07/2015
 * Time: 5:29 PM
 */

namespace enigmatix\widgets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $sourcePath = '@vendor/enigmatix/yii2-widgets';
    public $css = [
        'select2.min.css',
        'select2-bootstrap.css'
    ];
    public $js = [
        'select2.full.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}