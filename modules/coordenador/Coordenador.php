<?php

namespace app\modules\coordenador;
use Yii;
use yii\helpers\Url;
/**
 * coordenador module definition class
 */
class Coordenador extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\coordenador\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::$app->setHomeUrl(Url::to(['/coordenador/default/index']));
    }
}
