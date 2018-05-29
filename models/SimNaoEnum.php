<?php 

 namespace app\models;

 abstract class SimNaoEnum {
	const SIM = 'SIM';
	const NAO = 'NAO';

	public static function listar(){
		return [
			SimNaoEnum::SIM => 'Sim',
			SimNaoEnum::NAO => 'Não',
		];
	}
}