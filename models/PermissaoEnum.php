<?php 

 namespace app\models;

 abstract class PermissaoEnum {
	const PERMISSAO_ADMIN       = 'ADMIN';
	const PERMISSAO_COORDENADOR = 'COORDENADOR';
	const PERMISSAO_PROFESSOR  = 'PROFESSOR';
	const PERMISSAO_CANDIDATO  = 'CANDIDATO';

	public static function listar(){
		return [
			PermissaoEnum::PERMISSAO_ADMIN => 'Administrador',
			PermissaoEnum::PERMISSAO_COORDENADOR => 'Coordenador',
			PermissaoEnum::PERMISSAO_PROFESSOR => 'Professor',
		];
	}
}