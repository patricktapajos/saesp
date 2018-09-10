<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Atualizar Dados';
?>
<div class="candidato-update">
	<div class="panel">
    	<h1><i class="glyphicon glyphicon-pencil"></i><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'candidato' => $candidato,
        'smods' => $smods,
        'documento'=>$documento,
    ]) ?>

</div>
