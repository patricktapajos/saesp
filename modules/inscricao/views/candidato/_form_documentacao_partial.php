<?php 
	use yii\helpers\Html;
	$this->registerJs("

    function laudoPCD (attribute, value) {
        return $('#CAND_PCD').val() == 'SIM' && ($('#DOC_LAUDO_PCD_URL_AUX').val() == '' || $('#DOC_LAUDO_PCD_URL_AUX').val() == undefined);
    };

    function atestadoComorbidade (attribute, value) {
        return $('#CAND_TEM_COMORBIDADE').val() == 'SIM' && ($('#DOC_ATESTADO_URL_AUX').val() == '' || $('#DOC_ATESTADO_URL_AUX').val() == undefined);
    };

    function atestadoIdoso (attribute, value) {
        return $('#CAND_IDOSO').val() == 'SIM' && ($('#DOC_ATESTADO_IDOSO_AUX').val() == '' || $('#DOC_ATESTADO_IDOSO_AUX').val() == undefined);
    };

    function atestadoMenor (attribute, value) {
        return $('#CAND_MENOR_IDADE').val() == 'SIM' && ($('#DOC_DECLARACAO_MENOR_AUX').val() == '' || $('#DOC_DECLARACAO_MENOR_AUX').val() == undefined);
    };
");
?>

<div class="form-tab" id="documentacao">
	<div class="row">
		 <div class="col-lg-6 col-sm-12 text-center">
               <img src="<?= $candidato->getUrlFoto(); ?>" id="foto-candidato" width="160" height="150" />
               <?= $form->field($candidato, 'CAND_FOTO')->fileInput(['id'=>'urlfoto']); ?>
          </div>

		<div class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_RG_URL'); ?>" id="foto-rg" class="img-documentacao"/>
		    </div>
		    <?= $form->field($documento, 'DOC_RG_URL')->fileInput(['class'=>'urlfoto', 'id'=>'rg']); ?>
		</div>

	</div>
	
	<div class="row">
		<div class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_CPF_URL'); ?>" id="foto-cpf" class="img-documentacao"/>
		    </div>
		    <?= $form->field($documento, 'DOC_CPF_URL')->fileInput(['class'=>'urlfoto','id'=>'cpf']); ?>

		</div>
		<div class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_CRESID_URL'); ?>" id="foto-resid" class="img-documentacao"/>
		    </div>
		    <?= $form->field($documento, 'DOC_CRESID_URL')->fileInput(['class'=>'urlfoto','id'=>'resid']); ?>

		</div>
	</div>
 
 <!-- -->

	<div class="row">
		<div v-show="show_pcd == 'SIM'" class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_LAUDO_PCD_URL'); ?>" id="foto-laudo-pcd" class="img-documentacao" />
		    </div>
		    <?= $form->field($documento, 'DOC_LAUDO_PCD_URL')->fileInput(['class'=>'urlfoto','id'=>'laudo-pcd']); ?>
		    <?= $form->field($documento, 'DOC_LAUDO_PCD_URL_AUX')->hiddenInput(['id'=>'DOC_LAUDO_PCD_URL_AUX'])->label(false); ?>

		</div>

		<div v-show="show_comorbidade == 'SIM'" class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_ATESTADO_URL'); ?>" id="foto-laudo-comorbidade" class="img-documentacao" />
		    </div>
		    <?= $form->field($documento, 'DOC_ATESTADO_URL')->fileInput(['class'=>'urlfoto','id'=>'laudo-comorbidade']); ?>
		    <?= $form->field($documento, 'DOC_ATESTADO_URL_AUX')->hiddenInput(['id'=>'DOC_ATESTADO_URL_AUX'])->label(false); ?>

		</div>

		<div v-show="show_responsavel == 'SIM'" class="col-lg-6 col-sm-12 text-center">
				<div class="img-documentacao-cover">		
			    	<img src="<?= $documento->getUrlFoto('DOC_DECLARACAO_MENOR'); ?>" id="foto-menor" class="img-documentacao" />
			    </div>
			    <?= $form->field($documento, 'DOC_DECLARACAO_MENOR')->fileInput(['class'=>'urlfoto','id'=>'menor']); ?>
		    	<?= $form->field($documento, 'DOC_DECLARACAO_MENOR_AUX')->hiddenInput(['id'=>'DOC_DECLARACAO_MENOR_AUX'])->label(false); ?>

			</div>

		<div v-show="show_idoso == 'SIM'" class="col-lg-6 col-sm-12 text-center">
			<div class="img-documentacao-cover">
		    	<img src="<?= $documento->getUrlFoto('DOC_ATESTADO_IDOSO'); ?>" id="foto-idoso" class="img-documentacao" />
		    </div>
		    <?= $form->field($documento, 'DOC_ATESTADO_IDOSO')->fileInput(['class'=>'urlfoto','id'=>'idoso']); ?>
		    <?= $form->field($documento, 'DOC_ATESTADO_IDOSO_AUX')->hiddenInput(['id'=>'DOC_ATESTADO_IDOSO_AUX'])->label(false); ?>
		</div>
	</div>
</div>