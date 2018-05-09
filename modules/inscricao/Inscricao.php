<?php

namespace app\modules\inscricao;

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

        // custom initialization code goes here
    }
}
