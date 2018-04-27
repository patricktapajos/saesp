<?php
namespace app\components\rbac;
use yii\rbac\DbManager;

class SAESPAuthManager extends DbManager {
	
	public $_TABLE = 'usuario';
	public function checkAccess($userId, $itemName, $params=[]){

		$sql="SELECT USU_REGRA ".			 
			 "FROM ".$this->_TABLE.
			 " WHERE USU_REGRA=:rotina and USU_CPF = :userid";
		$command=$this->db->createCommand($sql);
		$command->bindValue(':rotina',$itemName);
		$command->bindValue(':userid',$userId);
		
		// check directly assigned items
		$row = $command -> queryOne();
				
		return $row;	
	}

	public function isAssigned($itemName,$userId)
	{		
		$sql="SELECT USU_REGRA ".			 
			 "FROM "._TABLE.			 			 
			 " WHERE USU_REGRA=:rotina and USU_CPF = :userid ";
		$command=$this->db->createCommand($sql);
		$command->bindValue(':rotina',$itemName);
		$command->bindValue(':userid',$userId);
		return $command->queryScalar()!==false;
	}
}