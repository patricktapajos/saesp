<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Coordenador;
use app\models\SituacaoEnum;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['username', 'validarCoordenador'],
            ['username', 'validarAtivo'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Usuário',
            'password' => 'Senha',
            'rememberMe' => 'Manter conectado'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword(md5($this->password))) {
                $this->addError($attribute, 'Usuário ou senha incorreta.');
            }
        }
    }

    public function validarCoordenador($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $coordenador = Coordenador::find()->where(['USU_ID'=>$user->id])->one();
            if($coordenador && !$coordenador->cel){
                $this->addError($attribute, 'Coordenador não está relacionado a nenhum CEL.');
            }
        }
    }

    public function validarAtivo($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $usuario = Usuario::findOne(['USU_ID'=>$user->id]);
            if($usuario->USU_SITUACAO == SituacaoEnum::INATIVO){
                $this->addError($attribute, 'Usuário está inativo e não pode acessar o sistema.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $this->username = preg_replace('/[^0-9]/', '', $this->username);
        
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}