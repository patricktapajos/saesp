<?php

 namespace app\modules\aluno\models;

 abstract class AlunoSituacaoEnum {
	const ATIVO   = 'ATIVO';
	const INATIVO = 'INATIVO';

	public static function listar(){
		return [
			AlunoSituacaoEnum::ATIVO => 'Ativo',
			AlunoSituacaoEnum::INATIVO => 'Inativo',
		];
	}
}