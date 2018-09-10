<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Atualizar Dados';
?>
<div class="candidato-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'candidato' => $candidato,
        'smods' => $smods
    ]) ?>

</div>
