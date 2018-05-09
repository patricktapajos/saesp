<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Ficha de Inscrição';
?>
<div class="candidato-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
