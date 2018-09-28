<?php

namespace app\models;
use app\models\Usuario;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $name;
    public $username;
    public $cel_nome;
    public $cel_id;
    public $password;
    public $authKey;
    public $accessToken;

     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $model = Usuario::findOne(['USU_ID'=>$id]);
        if($model){
            $user = new User;
            $user->name = $model->USU_NOME;
            $user->username = $model->USU_CPF;
            $user->id = $id;
            if($model->coordenador){
                $user->cel_nome = $model->coordenador->cel->CEL_NOME;
                $user->cel_id = $model->coordenador->cel->CEL_ID;
            }
            return $user;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $model = Usuario::findOne(['USU_CPF'=>$username]);

        if($model){
            $user = new User;
            $user->username = $model->USU_CPF;
            $user->password = $model->USU_SENHA;
            $user->id = $model->USU_ID;
            return $user;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}