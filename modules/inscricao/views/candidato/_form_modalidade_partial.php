<?php 
	use yii\helpers\Html;
?>
<div class="row table-saesp" id="modal">
	<?= $form->field($candidato, 'modalidades')->hiddenInput(['v-model'=>'modalidades']); ?>
	<div class="row text-center div-header">
        <div class="col-lg-3">CEL</div>
        <div class="col-lg-3">Modalidade</div>
        <div class="col-lg-2">Dia(s)</div>
        <div class="col-lg-2">Horário(s)</div>
        <div class="col-lg-1">Qtde. de Vagas</div>
        <div class="col-lg-1">Selecionar</div>
    </div>

     <div class="row div-body text-center">
		<?php foreach ($smods as $smod): ?>
			<div class="ptable-row">
				<div class="col-lg-3">
					<?php echo $smod->modalidade->cel->CEL_NOME; ?>
				</div>	
				<div class="col-lg-3">
					<?php echo $smod->modalidade->MOD_NOME; ?>
				</div>	
				<div class="col-lg-6">
					<?php foreach ($smod->modalidadeDataHora as $mdh) : ?>
		            	<div class="pinner-row">		
		            		<div class="col-lg-4">
								<?php echo $mdh->getDiasSemana(); ?>
							</div>	
							<div class="col-lg-4">
								<?php echo $mdh->getHorario(); ?>
							</div>	
							<div class="col-lg-2">
								<?php echo $mdh->MDT_QTDE_VAGAS; ?>
							</div>
							<div class="col-lg-2">
								<?php 
									if($mdh->MDT_QTDE_VAGAS >= $mdh->qtdeinscritos){
										echo $form->field($candidato, 'modalidade')->checkBox(['label'=>'','v-on:click'=>'adicionarModalidade($event)','value'=>$mdh->MDT_ID]);
									}else{
										echo "Vagas Esgotadas";
									}

								?>
							</div>	
		            	</div>
		            <?php endforeach; ?>
	            </div>
	        </div>
		<?php endforeach; ?>
    </div>
</div>