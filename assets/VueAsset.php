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
class VueAsset extends AssetBundle
{
    public $sourcePath = '@npm/vue/dist';
    public $css = [];
    public $js = [
        'vue.js'
    ];
      public $depends = [
        'app\assets\AppAsset',
    ];
}