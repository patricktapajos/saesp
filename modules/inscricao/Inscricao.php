<?php

namespace app\modules\inscricao;
use Yii;
use yii\helpers\Url;

/**
 * inscricao module definition class
 */
class Inscricao extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\inscricao\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/modules/inscricao/views/layouts/main';
        Yii::$app->setHomeUrl(Url::to(['/inscricao/default/index']));
        Yii::$app->user->loginUrl = ['inscricao/default/login'];
        // custom initialization code goes here
    }
}
