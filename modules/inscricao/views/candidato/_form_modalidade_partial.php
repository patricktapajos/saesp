<?php
	use yii\helpers\Html;	
?>
<div class="row table-saesp form-tab" id="modal">
	<?= $form->field($candidato, 'modalidades')->hiddenInput(['v-model'=>'modalidades'])->label(false); ?>
	<?= $form->field($candidato, 'validoaquatico')->hiddenInput(['id'=>'validoaquatico'])->label(false); ?>
	<?= $form->field($candidato, 'horariovalido')->hiddenInput(['id'=>'horariovalido'])->label(false); ?>
	<?= Html::hiddenInput('id', $candidato->usuario->USU_ID, ['id'=>'USU_ID']); ?>
	<?= Html::hiddenInput('qtdaquatico', 0, ['id'=>'qtdaquatico']); ?>
	
	<table class="table table-modalidade table-acao table-responsive">
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
        	<?php foreach ($scels as $scel): ?>
        		<tr>
        			<td><?php echo $scel->cel->CEL_NOME; ?></td>
					<td colspan="5">
						<table class="table table-modalidade-inner">
							<tbody>
								<?php foreach ($scel->selecaoModalidade as $sm) : ?>
									<tr>
										<td class="field-modalidade"><?php echo $sm->modalidade->MOD_NOME; ?></td>
										<td colspan="4">
											<table class="table-inner">
												<tbody>
													<?php foreach ($sm->modalidadeDataHora as $mdh) : ?>
														<tr>
															<td class="field2"><?php echo $mdh->getDiasSemana(); ?></td>
															<td class="field2"><?php echo $mdh->getHorario(); ?></td>
															<td class="field2"><?php echo $mdh->MDT_QTDE_VAGAS; ?></td>
															<td class="field2">
															<?php
																if($mdh->MDT_QTDE_VAGAS >= $mdh->qtdeinscritos){
																	echo $form->field($candidato, 'modalidade')->checkBox(['label'=>'','v-on:click'=>'adicionarModalidade($event.target.value, '. $sm->SMOD_ID.', '. $sm->modalidade->MOD_ID.')','value'=>$mdh->MDT_ID,'v-bind:id'=>$mdh->MDT_ID]);
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
					</td>
        		</tr>
			<?php endforeach; ?>
        </tbody>
    </table>
</div>
