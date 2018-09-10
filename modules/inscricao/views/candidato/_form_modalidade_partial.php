<?php 
	use yii\helpers\Html;
?>
<div class="row table-saesp form-tab" id="modal">
	<?= $form->field($candidato, 'modalidades')->hiddenInput(['v-model'=>'modalidades'])->label(false); ?>
	<table class="table table-acao table-responsive">
        <thead>
            <tr>
                <th class="field_cross2">CEL</th>
                <th class="field_cross2">Modalidade</th>
                <th class="field_cross_small">Dia(s)</th>
                <th class="field_cross_small">Horário(s)</th>
                <th class="field_cross_small">Nº de Vagas</th>
        		<th class="field_cross_small">Selecionar</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($smods as $smod): ?>
        		<tr>
        			<td><?php echo $smod->modalidade->cel->CEL_NOME; ?></td>
        			<td><?php echo $smod->modalidade->MOD_NOME; ?></td>
        			<td colspan="4">
        				<table class="table-inner">
        					<tbody>
        						<?php foreach ($smod->modalidadeDataHora as $mdh) : ?>
        							<tr>
        								<td class="field2"><?php echo $mdh->getDiasSemana(); ?></td>
        								<td class="field2"><?php echo $mdh->getHorario(); ?></td>
        								<td class="field2"><?php echo $mdh->MDT_QTDE_VAGAS; ?></td>
        								<td class="field2">
        								<?php 
											if($mdh->MDT_QTDE_VAGAS >= $mdh->qtdeinscritos){
												echo $form->field($candidato, 'modalidade')->checkBox(['label'=>'','v-on:click'=>'adicionarModalidade($event.target.value, '. $smod->SMOD_ID.', '. $smod->modalidade->MOD_ID.')','value'=>$mdh->MDT_ID,'v-bind:id'=>$mdh->MDT_ID]);
											}else{
												echo "Vagas Esgotadas";
											}

										?>
										</td>
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