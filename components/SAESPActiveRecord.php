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
		if($this->log->log_justificativa === null || $this->log->log_justificativa === ''){
			$this->log->log_justificativa = 'Sem justificativa';
		}
		$this->log->log_tabela = $this->tableName();
		if($this->isNewRecord){
			$this->log->log_acao = 'insert';
		}else{
			if($this->delete){
				$this->log->log_acao = 'delete';
			}
			else if(strlen($this->scenario)>0){
				$this->log->log_acao = $this->scenario;
			}else{
				$this->log->log_acao = 'update';
			}
			if(!in_array($this->tableSchema->primaryKey)){
				$this->log->fk_codigo = $this->getPrimaryKey();
			}else{
				$this->log->fk_codigo = implode("-", $this->getPrimaryKey());
			}
		}

		$this->log->save(false);

		return true;
	}

	public function afterSave(){

		parent::afterSave();
		if($this->isNewRecord and ($this->log !== null)){
			if(!is_array($this->tableSchema->primaryKey)){
				$this->log->fk_codigo = $this->getPrimaryKey();
			}else{
				$this->log->fk_codigo = implode("-", $this->getPrimaryKey());
			}
			return $this->log->update();
		}

		return true;
	}


}