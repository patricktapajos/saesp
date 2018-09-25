<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\coordenador\models\Aluno;
use app\modules\coordenador\models\AlunomodalidadeSearch;
use app\modules\coordenador\models\Alunomodalidade;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoDocumento;
use app\modules\inscricao\models\InscricaoSearch;
use app\models\SituacaoInscricaoEnum;
use app\assets\VueParecerAsset;

VueParecerAsset::register($this);

$this->registerJs(
    "$('#documentos').magnificPopup({
          delegate: 'a',
          type: 'image'
        });
    $('img').on('contextmenu', function(e) {
        return false;
    }); 
    $('img').on('dragstart', function(e) {
        return false;
    });",
    yii\web\View::POS_LOAD,
    'magnificpopup'
);

$this->registerJs(
    "function observacao (attribute, value) {
        return $('input[type=\'radio\']:checked').val() == 'INDEFERIDO' && $('#INS_OBSERVACAO').val() == '';
    };"
);
?>
<?php

$this->title = 'Emitir Parecer';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Parecer', 'url' => ['gerenciarparecer']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['method'=>'post']); ?>
    <div class="candidato-view" id="parecer">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="alert-danger">
            <?= $form->errorSummary([$model]); ?>
        </div>
        <div class="col-lg-12 col-sm-12">
            <h3><i class="glyphicon glyphicon-triangle-right"></i>Dados do Inscrito</h3>
            <div class="col-lg-6 col-sm-12">
                <?= DetailView::widget([
                    'model' => $model->candidato,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
                    'attributes' => [
                        'inscricao.INS_NUM_INSCRICAO',
                        'usuario.USU_NOME',
                        'usuario.USU_CPF',
                        'usuario.USU_EMAIL',
                        'usuario.USU_DT_NASC',

                                            [
                            'label'=>'Sexo',
                            'attribute'=>'USU_SEXO',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  $model->usuario->getSexoText();
                            }
                        ],

                        'usuario.USU_TELEFONE_1',
                        'usuario.USU_TELEFONE_2',

                        [
                            'label'=>'Estado Civil',
                            'attribute'=>'CAND_ESTADO_CIVIL',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  $model->getEstadoCivilText();
                            }
                        ],

                        'CAND_LOGRADOURO',
                        'CAND_COMPLEMENTO_END',
                    ],
                ]) ?>
            </div>
            <div class="col-lg-6 col-sm-12">
                <?= DetailView::widget([
                    'model' => $model->candidato,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
                    'attributes' => [
                        'CAND_CEP',
                        'CAND_BAIRRO',
                        'CAND_NOME_EMERGENCIA',
                        'CAND_TEL_EMERGENCIA',
                        'CAND_NOME_RESPONSAVEL',

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
                        <th class="field_cross_small">-</th>
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
                                <td>
                                <?= Html::checkBox('modalidade', true,[
                                        'label'=>'',
                                        'v-on:click'=>'adicionarModalidade("'. $mdh->MDT_ID.'")',
                                        'value'=>$mdh->MDT_ID,
                                        'class'=>'modclass',
                                        'v-bind:id'=>$mdh->MDT_ID]); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $form->field($model, 'modalidades')->hiddenInput(['v-model'=>'modalidades'])->label(false) ?>
        </div>

        <div class="col-sm-12">
            <h3><i class="glyphicon glyphicon-triangle-right"></i>Documentação</h3>
            <div class="row col-lg-offset-1 col-lg-10 col-lg-offset-1">
                <div class="jcarousel-wrapper documentos">
                    <div class="jcarousel" data-jcarousel="true" id="documentos">
                        <ul>
                            <?php foreach(array_values($model->inscricaodocumento->getDocumentosImagem()) as $n=>$foto) : ?>
                                <li style="width: auto; height: auto; padding: 5px">
                                    <a href="<?= $model->inscricaodocumento->getUrlDocumento($foto); ?>"
                                    title="<?= $model->inscricaodocumento->getAttributeLabel($foto) ?>" style="text-decoration: none; border:0">
                                        <img src="<?= $model->inscricaodocumento->getUrlDocumento($foto); ?>" class="img-documentacao">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a href="#" class="jcarousel-control-prev" data-jcarouselcontrol="true"></a>
                    <a href="#" class="jcarousel-control-next" data-jcarouselcontrol="true"></a>
                </div>

                <?php foreach(array_values($model->inscricaodocumento->getDocumentosPdf()) as $n=>$pdf) : ?>
                    <div class="col-lg-12 col-sm-12 text-center">
                        <span><b><?= $model->inscricaodocumento->getAttributeLabel($pdf); ?></b></span>
                        <embed src="<?= $model->inscricaodocumento->getUrlDocumento($pdf); ?>" type="application/pdf" width="100%" height="20%" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <h3><i class="glyphicon glyphicon-triangle-right"></i>Situação</h3>
            <div class="form-group">
                <?= $form->field($model, 'INS_SITUACAO')->radioList(SituacaoInscricaoEnum::listarparecer(), ['id'=>'INS_SITUACAO'])->label(false) ?>
            </div>
            <div id="divObs">
                <?php echo $form->field($model, 'INS_OBSERVACAO')->textarea(['id'=>'INS_OBSERVACAO']) ?>
            </div>
        </div>
        
    </div>
    <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancelar', ['/inscricao/default'] ,['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end(); ?>
