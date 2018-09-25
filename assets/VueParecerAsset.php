<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class VueParecerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/magnific-popup.css',
        'css/jcarousel.responsive.css', 
    ];
    public $js = [
        'js/jquery.jcarousel.min.js',
        'js/jquery.jcarousel.responsive.js',
        'js/magnific-popup.js',
        'js/jqueryBlockUI/jquery.blockUI.js',
        'js/constants/constants.js',
        'js/vue-components/modules-coord/parecer.js',
    ];
    public $depends = [
        'app\assets\VueAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
