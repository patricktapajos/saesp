<?php 
	
	namespace app\mail;
	use app\models\Usuario;

	$hora1  = strtotime('06:00');
	$hora2  = strtotime('12:00');
	$hora3  = strtotime('18:00');
	$horaAtual = strtotime(date('H:i'));
			
	if($horaAtual > $hora1 && $horaAtual < $hora2){
		$saudacao = 'Bom dia!';
	}else if ($horaAtual > $hora2 && $horaAtual < $hora3){
		$saudacao = 'Boa tarde!';
	}else{
		$saudacao = 'Boa noite!';
	}
?>
	<?php echo "<p style='font:normal normal 11px verdana;'>Atenção! Não há necessidade de responder esta mensagem.</p>";?>
	
	<table style="margin:auto;" border="1" cellspacing=0 cellpadding=2 bordercolor="F0FFFF">
		<tr style="margin:auto;">
			<td colspan="2">
				<table style="margin:auto;">
					<tr>
						<td>
							<?php echo "<p style='font:normal normal 11px verdana;'>".$saudacao."</p>";?>
						</td>
					</tr>
					<tr>
						<td>
							<?php if($model->scenario == Usuario::SCENARIO_ESQUECI_SENHA): ?>
								<p style="font: normal normal 11px verdana;">Sua senha para acesso ao sistema <b>SAESP</b> foi alterada.</p>
							<?php else: ?>
								<p style="font: normal normal 11px verdana;">Acesso cadastro com sucesso no <b>SAESP</b>.</p>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>
							<p style="font: normal normal 11px verdana;">Abaixo estão as informações necessárias para efetuar seu login.</p>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan="2">
							Usuário: <?php echo $model->USU_CPF;?>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan="2">
							Senha: <?php echo $senha ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>