<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\Nivel */

$this->title = 'Cadastrar Nível';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Nível', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nivel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
