<?php 

 namespace app\models;

 abstract class SituacaoInscricaoEnum {
	const DEFERIDA   = 'DEFERIDA';
	const INDEFERIDA = 'INDEFERIDA';
	const AGUARDE    = 'AGUARDE';

	public static function listar(){
		return [
			SituacaoInscricaoEnum::DEFERIDA => 'Deferida',
			SituacaoInscricaoEnum::INDEFERIDA => 'Indeferida',
			SituacaoInscricaoEnum::AGUARDE => 'Aguardando Parecer',
		];
	}
}