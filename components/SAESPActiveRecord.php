<?php 

namespace app\components;

use app\models\Log;

 class SAESPActiveRecord extends \yii\db\ActiveRecord {

    protected $log;
    protected $delete = false;
    

    public function beforeDelete(){
		if(parent::beforeDelete()){
			$this->delete = true;
			return $this->log();
		}
		return false;
	}

	public function beforeSave($insert){

		if(parent::beforeSave($insert)){
			return $this->log();
		}
		return false;
	}

	public function getLog(){
		if($this->log === null){
			$this->log = new Log();
		}
		return $this->log;
	}

	public function log(){

		$this->getLog(); 
		if($this->log->LOG_JUSTIFICATIVA === null || $this->log->LOG_JUSTIFICATIVA === ''){
			$this->log->LOG_JUSTIFICATIVA = 'Sem justificativa';
		}
		$this->log->LOG_TABELA = $this->tableName();
		if($this->isNewRecord){
			$this->log->LOG_ACAO = 'insert';
		}else{
			if($this->delete){
				$this->log->LOG_ACAO = 'delete';
			}
			else if(strlen($this->scenario)>0){
				$this->log->LOG_ACAO = $this->scenario;
			}else{
				$this->log->LOG_ACAO = 'update';
			}
			if(!in_array($this->tableSchema->primaryKey)){
				$this->log->FK_CODIGO = $this->getPrimaryKey();
			}else{
				$this->log->FK_CODIGO = implode("-", $this->getPrimaryKey());
			}
		}

		$this->log->save(false);

		return true;
	}

	public function afterSave(){

		parent::afterSave();
		if($this->isNewRecord and ($this->log !== null)){
			if(!is_array($this->tableSchema->primaryKey)){
				$this->log->FK_CODIGO = $this->getPrimaryKey();
			}else{
				$this->log->FK_CODIGO = implode("-", $this->getPrimaryKey());
			}
			return $this->log->update();
		}

		return true;
	}


}