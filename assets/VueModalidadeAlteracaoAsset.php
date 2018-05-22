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
class VueModalidadeAlteracaoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/jqueryBlockUI/jquery.blockUI.js',
        'js/constants/constants.js',
    	'js/vue-components/modules-coord/modalidade-alteracao.js'
    ];
    public $depends = [
        'app\assets\VueAsset',
        'yii\widgets\MaskedInputAsset',
        'yii\jui\JuiAsset'
    ];
}