<?php 

 namespace app\models;

 abstract class SexoEnum {
	const MASCULINO = 'MASCULINO';
	const FEMININO = 'FEMININO';

	public static function listar(){
		return [
			SexoEnum::MASCULINO => 'Masculino',
			SexoEnum::FEMININO => 'Feminino',
		];
	}
}