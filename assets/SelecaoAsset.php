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
 * @author BigCheese <bigcheese@gmail.com>
 * @since 2.0
 */
class SelecaoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/selecao-radio.css'
    ];
    public $js = [
    	'js/vue-components/selecao/selecao.js'
    ];
    public $depends = [
        'app\assets\VueAsset',
    ];
}