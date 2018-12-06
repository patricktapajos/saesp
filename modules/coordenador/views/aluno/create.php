<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */

$this->title = 'Cadastrar Aluno';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Aluno', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
