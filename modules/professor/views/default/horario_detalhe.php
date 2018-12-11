<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Horário Detalhado';
$this->params['breadcrumbs'][] = ['label' => 'Visualizar Horário', 'url' => ['visualizarhorario']];
$this->params['breadcrumbs'][] = $this->title;
?>

    
<h2><?= Html::encode($this->title) ?></h2>

<div class="form-group">
    <label>Professor</label>
    <div class="form-control"><?= Yii::$app->user->identity->name; ?></div>
</div>

<table class="table table-modalidade table-acao table-responsive">
    <thead>
        <tr>
            <th class="field_cross2">CEL</th>
            <th class="field_cross2">Modalidade</th>
            <th class="field_cross_small">Dia(s)</th>
            <th class="field_cross_small">Horário(s)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($smods as $smod): ?>
            <?php foreach ($smod->modalidadeDataHora as $mdh) : ?>
                <tr>
                    <td><?php echo $mdh->selecaoModalidade->cel->CEL_NOME; ?></td>
                    <td><?php echo $mdh->selecaoModalidade->modalidade->MOD_NOME; ?></td>
                    <td><?php echo $mdh->getDiasSemana(); ?></td>
                    <td><?php echo $mdh->getHorario(); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>