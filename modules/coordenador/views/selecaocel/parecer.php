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
  use app\assets\ViewCandidatoAsset;


	$this->registerJs("
		  window.onload = function(){
				 $('#ins_obs').hide();
			}
			$('#ins_parecer :radio').change(function(){
			    var valor = $(this).val();
					if(valor == 'DEFERIDA'){
						$('#ins_obs').hide();
					}else{
						$('#ins_obs').show();
					}
			    //alert(valor);
			});
	");
?>
<?php

$this->title = 'Visualização de Dados do Inscrito';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
                'method'=>'post'
            ]); ?>
<div class="candidato-view">

    <h2><i class="glyphicon glyphicon-triangle-right"></i><?= Html::encode($this->title) ?></h2>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <?= DetailView::widget([
                'model' => $model,
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

    <h3><i class="glyphicon glyphicon-triangle-right"></i>Modalidade(s)</h3>

    <table class="table table-acao table-responsive">
        <thead>
            <tr>
                <th class="field_cross2">CEL</th>
                <th class="field_cross2">Modalidade</th>
                <th class="field_cross_small">Dia(s)</th>
                <th class="field_cross_small">Horário(s)</th>
								<th class="field_cross_small">Aprovado</th>
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
												<td><input type="checkbox" id="idmod[]" name="idmod[]" checked="true[]"  value="<?php echo $mdh->MDT_ID; ?>"/></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3><i class="glyphicon glyphicon-triangle-right"></i>Documentação</h3>
    <div class="row col-lg-offset-1 col-lg-12 col-lg-offset-12 col-sm-12">
        <div class="jcarousel-wrapper documentos">
            <div class="jcarousel" data-jcarousel="true" id="documentos">
                <ul>
                <?php foreach(array_values($model->inscricao->inscricaodocumento->getDocumentosImagem()) as $n=>$foto) : ?>
                     <li style="width: auto; height: auto; padding: 5px">
                        <a href="<?= $model->inscricao->inscricaodocumento->getUrlDocumento($foto); ?>"
                        title="<?= $model->inscricao->inscricaodocumento->getAttributeLabel($foto) ?>" style="text-decoration: none; border:0">
                            <img src="<?= $model->inscricao->inscricaodocumento->getUrlDocumento($foto); ?>" class="img-documentacao">
                        </a>
                     </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <a href="#" class="jcarousel-control-prev" data-jcarouselcontrol="true"></a>
            <a href="#" class="jcarousel-control-next" data-jcarouselcontrol="true"></a>
        </div>

        <div>
          <?php foreach(array_values($model->inscricao->inscricaodocumento->getDocumentosPdf()) as $n=>$pdf) : ?>
            <div class="col-lg-12 col-sm-12 text-center">
                <span><b><?= $model->inscricao->inscricaodocumento->getAttributeLabel($pdf); ?></b></span>
                <embed src="<?= $model->inscricao->inscricaodocumento->getUrlDocumento($pdf); ?>" type="application/pdf" width="100%" height="20%" />
            </div>
         <?php endforeach; ?>
			  </div>
    </div>
    <div>
		</div>
		<div class="form-group">
			<h3><i class="glyphicon glyphicon-triangle-right"></i>Emitir Parecer</h3>
			<div class="col-lg-6 col-sm-12">
				 <?= $form->field($model->inscricao, 'ins_parecer')->radioList(SituacaoInscricaoEnum::listarparecer(), ['id'=>'ins_parecer']) ?>
		  </div>
		</div>
		<div >
			<?php echo $form->field($model->inscricao, 'INS_OBSERVACAO')->textarea(['id'=>'ins_obs']) ?>
		</div>
</div>
<div class="form-group">
		<?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Cancelar', ['/inscricao/default'] ,['class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>
