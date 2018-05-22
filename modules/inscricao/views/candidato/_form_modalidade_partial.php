<?php 
	use yii\helpers\Html;
?>
<div class="row">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Centro de Lazer e Esporte</th>
				<th>Modalidade</th>
				<th>Dia(s) - Horário(s)</th>
				<th>Selecionar</th>
            </tr>
		</thead>
		<tbody>
		<?php foreach ($modalidades as $key => $smod) : ?>
			<tr>
				<td><?php echo $smod->modalidade->cel->CEL_NOME; ?></td>
				<td><?php echo $smod->modalidade->MOD_DESCRICAO; ?></td>
				<td><?php echo $smod->getDiasSemana(); ?></td>
				<td><?= Html::activeCheckBox($candidato,'modalidades',[]); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>