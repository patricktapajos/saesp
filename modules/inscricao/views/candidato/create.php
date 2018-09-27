<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Ficha de Inscrição';
?>

<div class="candidato-create">
	<div class="panel panel-primary">
		<div class="panel-heading">
    		<div class="panel-title"><?= Html::encode($this->title) ?></div>
  		</div>
		<div class="panel-body">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'candidato' => $candidato,
		        'documento'=>$documento,
		        'smods' => $smods
		    ]) ?>
		</div>
	</div>
</div>
