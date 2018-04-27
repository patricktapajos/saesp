<?php 

 namespace app\models;

 abstract class PermissaoEnum {
	const PERMISSAO_ADMIN = 'ADMIN';
	const PERMISSAO_COORDENADOR = 'COORDENADOR';

	public static function listar(){
		return [
			PermissaoEnum::PERMISSAO_ADMIN => 'Administrador',
			PermissaoEnum::PERMISSAO_COORDENADOR => 'Coordenador',
		];
	}
}