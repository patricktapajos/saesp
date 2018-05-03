<?php
namespace app\components\rbac;
use yii\rbac\DbManager;
use app\models\Usuario;

class SAESPAuthManager extends DbManager {
	
	public function checkAccess($userId, $itemName, $params=[]){

		$row = Usuario::find()->where('USU_ID = :USU_ID and USU_PERMISSAO = :USU_PERMISSAO', [':USU_ID'=>$userId,':USU_PERMISSAO'=>$itemName])->one();
		return $row!==null;	
	}

	public function isAssigned($itemName,$userId)
	{		
		$row = Usuario::find()->where('USU_ID = :USU_ID and USU_PERMISSAO = :USU_PERMISSAO', [':USU_ID'=>$userId,':USU_PERMISSAO'=>$itemName])->one();
		return $row->count()!==false;
	}
}