<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */
$this->title = 'Comprovante de Inscrição';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="candidato-view">

    <div class="header">
        <img class="logo-prefeitura" src="<?= Yii::getAlias('images') ?>/brasao.png" width="40" height="46">
        <img class="logo-sistema" src="<?= Yii::getAlias('images') ?>/logo.png" width="130" height="50">
        <div class="titulo"><?= Html::encode($this->title) ?></div>
    </div>


    <h3><i class="glyphicon glyphicon-triangle-right"></i>Dados Gerais(s)</h3>

    <div class="col-lg-9 col-sm-12">
     <?= DetailView::widget([
            'model' => $model,
            //'template'=>'<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
            'options'=>['class'=>'table-detail'],
            'attributes' => [
               'inscricao.INS_NUM_INSCRICAO',
               'usuario.USU_NOME',
                'usuario.USU_CPF',
                'usuario.USU_EMAIL',
                'usuario.USU_DT_NASC',
                [
                    'label'=>'PcD (Pessoa Com Deficiência)',
                    'attribute'=>'CAND_PCD',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_PCD');
                    }
                ],
                'CAND_PCD_DESC',
                [
                    'label'=>'Possui alguma comorbidade?',
                    'attribute'=>'CAND_TEM_COMORBIDADE',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_TEM_COMORBIDADE');
                    }
                ],
                'CAND_COMORBIDADE_DESC',
                [
                    'label'=>'ingere algum medicamento',
                    'attribute'=>'CAND_TEM_MEDICACAO',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_TEM_MEDICACAO');
                    }
                ],
                'CAND_MEDICACAO_DESC',
                'CAND_OBSERVACOES',
            ],
        ]) ?>
    </div>
    
    <h3><i class="glyphicon glyphicon-triangle-right"></i>Modalidade(s)</h3>

    <table class="table table-acao table-responsive">
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
                        <td><?php echo $mdh->selecaoModalidade->modalidade->cel->CEL_NOME; ?></td>
                        <td><?php echo $mdh->selecaoModalidade->modalidade->MOD_DESCRICAO; ?></td>
                        <td><?php echo $mdh->getDiasSemana(); ?></td>
                        <td><?php echo $mdh->getHorario(); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>