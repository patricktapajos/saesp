<?php

namespace app\modules\professor;
use Yii;
use yii\helpers\Url;

/**
 * professor module definition class
 */
class Professor extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\professor\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->setHomeUrl(Url::to(['/professor/default/index']));
        // custom initialization code goes here
    }
}
