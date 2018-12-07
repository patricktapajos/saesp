<?php 

 namespace app\models;

 abstract class SituacaoSelecaoEnum {
	const CADASTRADO            			= 'CADASTRADO';
	const INSCRICOES_ABERTAS    			= 'INSCRICOES_ABERTAS';
	const INSCRICOES_ENCERRADAS 			= 'INSCRICOES_ENCERRADAS';
	const PARECER_ABERTO 					= 'PARECER_ABERTO';
	const PARECER_ENCERRADO					= 'PARECER_ENCERRADO';
	const CONCLUIDO 						= 'CONCLUIDO';
	/*const VAGAS_REMANESCENTES_ABERTO  		= 'VAGAS_RMN_ABERTO';
	const VAGAS_REMANESCENTES_ENCERRADO   	= 'VAGAS_RMN_ENCERRADO';*/

	public static function listarInicio(){
		return [
			SituacaoSelecaoEnum::CADASTRADO => 'Seleção Cadastrada',
		];
	}

	public static function listarInscricoes(){
		return [
			SituacaoSelecaoEnum::INSCRICOES_ABERTAS => 'Inscrições Abertas',
			SituacaoSelecaoEnum::INSCRICOES_ENCERRADAS => 'Inscrições Encerradas',
		];
	}

	public static function listarParecer(){
		return [
			SituacaoSelecaoEnum::PARECER_ABERTO => 'Emissão de Parecer Aberto',
			SituacaoSelecaoEnum::PARECER_ENCERRADO => 'Emissão de Parecer Encerrado',
		];
	}

	public static function listarEncerrar(){
		return [
			SituacaoSelecaoEnum::CONCLUIDO => 'Seleção Concluída',
		];
	}

	/*public static function listarVagasRemanescentes(){
		return [
			SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ABERTO => 'Vagas Restantes Aberto',
			SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ENCERRADO => 'Vagas Restantes Encerrado',
		];
	}*/

	public static function listar(){
		return [
			SituacaoSelecaoEnum::CADASTRADO => 'Apenas Cadastrada',
			SituacaoSelecaoEnum::INSCRICOES_ABERTAS => 'Inscrições Abertas',
			SituacaoSelecaoEnum::INSCRICOES_ENCERRADAS => 'Inscrições Encerradas',
			SituacaoSelecaoEnum::PARECER_ABERTO => 'Emissão de Parecer Aberto',
			SituacaoSelecaoEnum::PARECER_ENCERRADO => 'Emissão de Parecer Encerrado',
			SituacaoSelecaoEnum::CONCLUIDO => 'Concluída',
			/*SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ABERTO => 'Vagas Restantes Aberto',
			SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ENCERRADO => 'Vagas Restantes Encerrado',*/
		];
	}
}