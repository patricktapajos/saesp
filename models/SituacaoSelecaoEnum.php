<?php 

 namespace app\models;

 abstract class SituacaoSelecaoEnum {
	const CADASTRADO            = 'CADASTRADO';
	const INSCRICOES_ABERTAS    = 'INSCRICOES_ABERTAS';
	const INSCRICOES_ENCERRADAS = 'INSCRICOES_ENCERRADAS';
	const PARECER = 'PARECER';
	const CONCLUIDO = 'CONCLUIDO';

	public static function listar(){
		return [
			SituacaoSelecaoEnum::CADASTRADO => 'Apenas Cadastrada',
			SituacaoSelecaoEnum::INSCRICOES_ABERTAS => 'Inscrições Abertas',
			SituacaoSelecaoEnum::INSCRICOES_ENCERRADAS => 'Inscrições Encerradas',
			SituacaoSelecaoEnum::PARECER => 'Emissão de Parecer',
			SituacaoSelecaoEnum::CONCLUIDO => 'Concluída',
		];
	}
}