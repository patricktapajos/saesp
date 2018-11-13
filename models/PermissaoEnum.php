<?php

 namespace app\models;

 abstract class PermissaoEnum {
	const PERMISSAO_ADMIN       = 'ADMIN';
	const PERMISSAO_COORDENADOR = 'COORDENADOR';
  	const PERMISSAO_ESTAGIARIO = 'ESTAGIARIO';
	const PERMISSAO_PROFESSOR  = 'PROFESSOR';
	const PERMISSAO_CANDIDATO  = 'CANDIDATO';
	const PERMISSAO_ALUNO      = 'ALUNO';

	public static function listar(){
		return [
			PermissaoEnum::PERMISSAO_ADMIN => 'Administrador',
			PermissaoEnum::PERMISSAO_COORDENADOR => 'Coordenador',
      		PermissaoEnum::PERMISSAO_ESTAGIARIO  => 'Estagiário',
			PermissaoEnum::PERMISSAO_PROFESSOR => 'Professor',
		];
	}

	public static function listarSearch(){
		return [
			PermissaoEnum::PERMISSAO_ADMIN => 'Administrador',
			PermissaoEnum::PERMISSAO_COORDENADOR => 'Coordenador',
      	    PermissaoEnum::PERMISSAO_ESTAGIARIO => 'Estagiario',
			PermissaoEnum::PERMISSAO_PROFESSOR => 'Professor',
			PermissaoEnum::PERMISSAO_CANDIDATO => 'Candidato',
			PermissaoEnum::PERMISSAO_ALUNO => 'Aluno',
		];
	}
}
