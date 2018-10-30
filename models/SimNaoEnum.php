<?php 

 namespace app\models;

 abstract class SimNaoEnum {
	const SIM = '1';
	const NAO = '0';

	public static function listar(){
		return [
			SimNaoEnum::SIM => 'Sim',
			SimNaoEnum::NAO => 'Não',
		];
	}
}