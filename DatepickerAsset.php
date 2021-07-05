<?php
/**
 * Created by PhpStorm.
 * User: Joel Small
 * Date: 13/07/2015
 * Time: 5:29 PM
 */

namespace enigmatix\widgets;

use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap-datepicker/dist';
    public $css = [
        'css/bootstrap-datepicker.min.css',
        'css/bootstrap-datepicker.css'
    ];
    public $js = [
        'js/bootstrap-datepicker.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
