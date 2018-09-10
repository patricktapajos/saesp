<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Ficha de Inscrição';
?>

<div class="candidato-create">
	<div class="panel panel-primary">
		<div class="panel-heading">
    		<h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
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
