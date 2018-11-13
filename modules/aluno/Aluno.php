<?php

namespace app\modules\aluno;
use Yii;
use yii\helpers\Url;

/**
 * Aluno module definition class
 */
class Aluno extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\aluno\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/modules/aluno/views/layouts/main';
        Yii::$app->setHomeUrl(Url::to(['/aluno/default/index']));
    }
}
