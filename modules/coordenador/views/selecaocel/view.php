<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = 'Visualizar Modalidades';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção/CEL', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($model->selecao->isCadastrado()): ?>
    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->SCEL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->SCEL_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja excluir esse registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <div class="form-group">
        <label>Seleção</label>
        <div class="form-control"><?= $model->selecao->SEL_DESCRICAO; ?></div>
    </div>
    
    <table class="table table-modalidade table-acao table-responsive">
        <thead>
            <tr>
                <th class="field_cross">Modalidade</th>
                <th class="field_cross">Professor</th>
                <th class="field_date">Dias da Semana</th>
                <th class="field_date">Horário</th>
                <th class="field_small">Nº de Vagas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($smods as $smod): ?>
                <tr>
                    <td class="field_date"><?php echo $smod->modalidade->MOD_NOME; ?></td>
                    <td colspan="4">
        				<table class="table-complement">
        					<tbody>
        						<?php foreach ($smod->modalidadeDataHora as $mdh) : ?>
        							<tr>
        								<td style="width: 274px"><?php echo $mdh->professor->usuario->USU_NOME; ?></td>
        								<td style="width: 245px"><?php echo $mdh->getDiasSemana(); ?></td>
        								<td style="width: 245px"><?php echo $mdh->getHorario(); ?></td>
        								<td class="field_small"><?php echo $mdh->MDT_QTDE_VAGAS; ?></td>
        							</tr>
								<?php endforeach; ?>
        					</tbody>
        				</table>
        			</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    

</div>

<style>
    td.field {
        height: 40px;
    }
    th.field_date {
       width: 245px;
    }
    th.field_small {
        min-width: 120px;
    }
</style>

