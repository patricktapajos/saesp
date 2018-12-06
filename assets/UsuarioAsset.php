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
class UsuarioAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
    	'js/vue-components/usuario/usuario.js'
    ];
    public $depends = [
        'app\assets\VueAsset',
    ];
}