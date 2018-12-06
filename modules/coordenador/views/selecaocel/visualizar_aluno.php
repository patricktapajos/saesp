<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */

$this->title = 'Visualizando Aluno';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Parecer', 'url' => ['gerenciarparecer']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Imprimir Carteirinha', ['aluno/imprimircarteirinha', 'id' => $model->ALU_ID], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Voltar', ['selecaocel/gerenciarparecer'], ['class' => 'btn btn-danger']) ?>
    </p>
    <div class="col-lg-6 col-sm-12">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'inscricao.INS_NUM_INSCRICAO',
                'candidato.usuario.USU_NOME',
                'candidato.usuario.USU_CPF',
                'candidato.usuario.USU_EMAIL',
                'candidato.usuario.USU_DT_NASC',
                    [
                    'label'=>'Sexo',
                    'attribute'=>'USU_SEXO',
                    'format' => 'raw',
                    'value' => function ($model) {
                            return  $model->candidato->usuario->getSexoText();
                    }
                ],
                'candidato.usuario.USU_TELEFONE_1',
                'candidato.usuario.USU_TELEFONE_2',
                [
                    'label'=>'Estado Civil',
                    'attribute'=>'CAND_ESTADO_CIVIL',
                    'format' => 'raw',
                    'value' => function ($model) {
                            return  $model->candidato->getEstadoCivilText();
                    }
                ],
                'candidato.CAND_LOGRADOURO',
                'candidato.CAND_COMPLEMENTO_END'
            ],
        ]) ?>
    </div>

    <div class="col-lg-6 col-sm-12">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'candidato.CAND_CEP',
                'candidato.CAND_BAIRRO',
                'candidato.CAND_NOME_EMERGENCIA',
                'candidato.CAND_TEL_EMERGENCIA',
                'candidato.CAND_NOME_RESPONSAVEL',
                [
                    'label'=>'PcD (Pessoa Com Deficiência)',
                    'attribute'=>'CAND_PCD',
                    'format' => 'raw',
                    'value' => function ($model) {
                            return  $model->candidato->getSimNaoText('CAND_PCD');
                    }
                ],
                'candidato.CAND_PCD_DESC',
                [
                    'label'=>'Possui alguma comorbidade?',
                    'attribute'=>'CAND_TEM_COMORBIDADE',
                    'format' => 'raw',
                    'value' => function ($model) {
                            return  $model->candidato->getSimNaoText('CAND_TEM_COMORBIDADE');
                    }
                ],
                'candidato.CAND_COMORBIDADE_DESC',
                [
                    'label'=>'ingere algum medicamento',
                    'attribute'=>'CAND_TEM_MEDICACAO',
                    'format' => 'raw',
                    'value' => function ($model) {
                            return  $model->candidato->getSimNaoText('CAND_TEM_MEDICACAO');
                    }
                ],
                'candidato.CAND_MEDICACAO_DESC',
                'candidato.CAND_OBSERVACOES',
            ],
        ]) ?>
    </div>

    <div>
        <h3><i class="glyphicon glyphicon-triangle-right"></i>Modalidade(s)</h3>
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
    </div>
</div>
