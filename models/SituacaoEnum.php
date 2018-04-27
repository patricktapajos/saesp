<?php 

 namespace app\models;

 abstract class SituacaoEnum {
	const ATIVO = 'ATIVO';
	const INATIVO = 'INATIVO';

	public static function listar(){
		return [
			SituacaoEnum::ATIVO => 'Ativo',
			SituacaoEnum::INATIVO => 'Inativo',
		];
	}
}