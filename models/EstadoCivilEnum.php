<?php 

 namespace app\models;

 abstract class EstadoCivilEnum {

	const SOLTEIRO      = 'SOLTEIRO';
	const CASADO        = 'CASADO';
	const VIUVO         = 'VIUVO';
	const DIVORCIADO    = 'DIVORCIADO';
	const UNIAO_ESTAVEL = 'UNIAO_ESTAVEL';

	public static function listar(){
		return [
			EstadoCivilEnum::SOLTEIRO => 'Solteiro(a)',
			EstadoCivilEnum::CASADO => 'Casado(a)',
			EstadoCivilEnum::VIUVO => 'Viúvo(a)',
			EstadoCivilEnum::DIVORCIADO => 'Divorciado(a)',
			EstadoCivilEnum::UNIAO_ESTAVEL => 'União Estável',
		];
	}
}