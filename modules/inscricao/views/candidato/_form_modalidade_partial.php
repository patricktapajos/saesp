<?php 
	use yii\helpers\Html;
?>
<div class="row table-saesp">
	<div class="row text-center div-header">
        <div class="col-lg-3">Centro de Lazer e Esporte</div>
        <div class="col-lg-3">Modalidade</div>
        <div class="col-lg-2">Dia(s)</div>
        <div class="col-lg-2">Horário(s)</div>
        <div class="col-lg-2">Selecionar</div>
    </div>

     <div class="row div-body text-center">
		<?php foreach ($smods as $smod) : ?>
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
							<div class="col-lg-4">
								<?= Html::activeCheckBox($candidato,'modalidades['.$mdh->MDT_ID.']',['label'=>'']); ?>
							</div>	
		            	</div>
		            <?php endforeach; ?>
	            </div>
	        </div>
		<?php endforeach; ?>
    </div>
</div>