<?php

namespace app\models;
use app\models\Administrador;
use app\models\Coordenador;
use app\models\SexoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use yiibr\brvalidator\CpfValidator;
use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $usu_id
 * @property string $usu_nome
 * @property string $usu_cpf
 * @property string $usu_email
 * @property string $usu_dt_nasc
 * @property string $usu_sexo
 * @property string $usu_telefone_1
 * @property string $usu_telefone_2
 * @property string $usu_senha
 * @property string $usu_situacao
 * @property string $usu_permissao
 * @property  $
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'USUARIO';
    }

    /*public static function primaryKey(){
        return 'usu_id';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usu_id', 'usu_nome', 'usu_cpf', 'usu_email', 'usu_sexo', 'usu_dt_nasc','usu_permissao'], 'required'],
            [['usu_nome', 'usu_email', 'usu_senha'], 'string', 'max' => 255],
            ['usu_email','email'],
            [['usu_email'],'validarHostEmail','on' =>'insert, update'],
            [['usu_dt_nasc'], 'date'],
            [['usu_cpf'],CpfValidator::className()],
            [['usu_cpf'], 'string', 'max' => 14],
            [['usu_dt_nasc'], 'string', 'max' => 10],
            [['usu_sexo'], 'string', 'max' => 15],
            [['usu_telefone_1', 'usu_telefone_2', 'usu_situacao'], 'string', 'max' => 14],
            [['usu_permissao'], 'string', 'max' => 20],
            [['usu_cpf'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usu_id' => 'Código',
            'usu_nome' => 'Nome',
            'usu_cpf' => 'CPF',
            'usu_email' => 'Email',
            'usu_dt_nasc' => 'Data de Nascimento',
            'usu_sexo' => 'Sexo',
            'usu_telefone_1' => 'Telefone 1',
            'usu_telefone_2' => 'Telefone 2',
            'usu_senha' => 'Senha',
            'usu_situacao' => 'Situação',
            'usu_permissao' => 'Permissão', 
        ];
    }

    public function validarHostEmail($attribute, $params){
        if(strpos( $this->$attribute, 'pmm.am.gov.br' ) !== false){
            $this->addError($this,$attribute, 'O email deve ser institucional (@pmm.am.gov.br)');
            //return true;
        }
        $this->addError($attribute, 'O email deve ser institucional (@pmm.am.gov.br)');
    }

    public function beforeValidate(){
        $this->usu_cpf = preg_replace('/[^0-9]/', '', $this->usu_cpf);
        return parent::beforeValidate();
    }

    public function salvarUsuarioPorPermissao(){
        switch ($this->usu_permissao) {
            case PermissaoEnum::PERMISSAO_ADMIN:
                $admin = new Administrador();
                $admin->usu_id = $this->usu_id;
                break;
            
            case PermissaoEnum::PERMISSAO_COORDENADOR:
                $coord = new Coordenador();
                $coord->usu_id = $this->usu_id;
                break;
        }
    }

    public function beforeSave(){
        if($this->isNewRecord){
            $this->gerarSenha();
        }
        return parent::beforeSave();
    }

    public function afterSave(){
        if($this->isNewRecord){
            $this->salvarUsuarioPorPermissao();
        }
        return afterSave();
    }

    public function getSexoText(){
        return SexoEnum::listar()[$this->usu_sexo];
    }

    public function getPermissaoText(){
        return PermissaoEnum::listar()[$this->usu_permissao];
    }

    public function getSituacaoText(){
        return SituacaoEnum::listar()[$this->usu_situacao];
    }

    /*public function enviarEmail(){
        
        $mailer=new CMailer();
        $mailer->AddAddress($this->usu_email);
                
        //Cabeçalho
        if($this->scenario == 'esqueci')
            $mailer->Subject=Yii::t('', '[SISCONP] Alteração de senha');    
        else
            $mailer->Subject=Yii::t('', '[SISCONP] Confirmação de Cadastro de Acesso'); 
    
        
        //Conteúdo do email baseado no conteúdo da view chamada
        $mailer->getView('email',array('model'=>$this,'senha'=>$senha == null ? $this->_senha_atual : $senha),null);
        
        
        if(!$mailer->Send()){
            return false;
        }
        
        return true;
    }*/

    public function gerarSenha(){
        
        /*Gera senha aleatória*/
        $senha = strtolower($this->getRandomString());
        /*Encripta para salvar*/
        $this->usu_senha = md5($senha); 
        /*Retorna senha não encriptada para enviar para email*/
        return $senha; 
    }
    
    public function getRandomString($length = 6) {
        
        $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ0123456789";
        $validCharNumber = strlen($validCharacters);
     
        $result = "";
     
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
     
        return $result;
    }
}