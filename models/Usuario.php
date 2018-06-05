<?php

namespace app\models;
use app\models\Administrador;
use app\models\Coordenador;
use app\models\Professor;
use app\modules\inscricao\models\Candidato;
use app\models\SexoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use yiibr\brvalidator\CpfValidator;
use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $USU_ID
 * @property string $USU_NOME
 * @property string $USU_CPF
 * @property string $USU_EMAIL
 * @property string $USU_DT_NASC
 * @property string $USU_SEXO
 * @property string $USU_TELEFONE_1
 * @property string $USU_TELEFONE_2
 * @property string $USU_SENHA
 * @property string $USU_SITUACAO
 * @property string $USU_PERMISSAO
 * @property  $
 */
class Usuario extends \yii\db\ActiveRecord
{
    public $_senha_atual;
    public $_nova_senha;
    public $_nova_senha_confirmacao;
    const SCENARIO_ESQUECI_SENHA = 'SCENARIO_ESQUECI_SENHA';
    const SCENARIO_ALTERAR_SENHA = 'SCENARIO_ALTERAR_SENHA';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'USUARIO';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_ESQUECI_SENHA] = ['USU_CPF'];
        $scenarios [self::SCENARIO_ALTERAR_SENHA] = ['USU_CPF','_senha_atual','_nova_senha','_nova_senha_confirmacao'];
        return $scenarios;
    }

    /*public static function primaryKey(){
        return 'USU_ID';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_NOME', 'USU_CPF', 'USU_EMAIL', 'USU_SEXO', 'USU_DT_NASC','USU_PERMISSAO','USU_SITUACAO'], 'required','on'=>['insert','update','default']],
            [['USU_NOME', 'USU_EMAIL', 'USU_SENHA'], 'string', 'max' => 255],
            ['USU_EMAIL','email'],
            ['USU_CPF','required','on'=>[self::SCENARIO_ESQUECI_SENHA]],
            //[['USU_EMAIL'],'validarHostEmail','on'=>['insert','']],
            [['USU_DT_NASC'], 'date'],
            [['USU_CPF'], CpfValidator::className()],
            [['USU_CPF'], 'string', 'max' => 14],
            [['USU_DT_NASC'], 'string', 'max' => 10],
            [['USU_DT_NASC'], 'date', 'format'=>'d/m/Y'],
            [['USU_SEXO'], 'string', 'max' => 15],
            [['USU_TELEFONE_1', 'USU_TELEFONE_2', 'USU_SITUACAO'], 'string', 'max' => 14],
            [['USU_PERMISSAO'], 'string', 'max' => 20],
            [['USU_CPF'], 'unique','on'=>['insert','update','default']],
            [['USU_CPF','_senha_atual', '_nova_senha', '_nova_senha_confirmacao'], 'required', 'on'=>[self::SCENARIO_ALTERAR_SENHA]],
            ['_nova_senha_confirmacao', 'compare', 'compareAttribute' => '_nova_senha','on'=>[self::SCENARIO_ALTERAR_SENHA]],
            [['_nova_senha'],'validaNovaSenha','on'=>[self::SCENARIO_ALTERAR_SENHA]],
            [['_senha_atual'],'validaSenhaAntiga','on'=>[self::SCENARIO_ALTERAR_SENHA]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USU_ID' => 'Código',
            'USU_NOME' => 'Nome',
            'USU_CPF' => 'CPF',
            'USU_EMAIL' => 'Email',
            'USU_DT_NASC' => 'Data de Nascimento',
            'USU_SEXO' => 'Sexo',
            'USU_TELEFONE_1' => 'Telefone 1',
            'USU_TELEFONE_2' => 'Telefone 2',
            'USU_SENHA' => 'Senha',
            'USU_SITUACAO' => 'Situação',
            'USU_PERMISSAO' => 'Perfil', 
            '_nova_senha_confirmacao' => 'Confirmar nova senha'
        ];
    }

    /*
    * Relations
    *
    */

     public function getCoordenador(){
        return $this->hasOne(Coordenador::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getProfessor(){
        return $this->hasOne(Professor::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getAdministrador(){
        return $this->hasOne(Administrador::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getCandidato(){
        return $this->hasOne(Candidato::className(), ['USU_ID'=>'USU_ID']);
    }

     /*
    * Fim das Relations
    *
    */

    /*public function validarHostEmail($attribute, $params){
        if(strpos( $this->$attribute, 'pmm.am.gov.br' ) !== false){            
            return true;
        }
        $this->addError($attribute, 'O email deve ser institucional (@pmm.am.gov.br)');
        return false;
    }*/

    public function beforeValidate(){
        $this->USU_CPF = preg_replace('/[^0-9]/', '', $this->USU_CPF);
        $this->USU_TELEFONE_1 = preg_replace('/[^0-9]/', '', $this->USU_TELEFONE_1);
        $this->USU_TELEFONE_2 = preg_replace('/[^0-9]/', '', $this->USU_TELEFONE_2);
        return parent::beforeValidate();
    }

    public function salvarUsuarioPorPermissao(){
        switch ($this->USU_PERMISSAO) {
            case PermissaoEnum::PERMISSAO_ADMIN:
                $admin = new Administrador();
                $admin->USU_ID = $this->USU_ID;
                $admin->save(false);
                break;
            
            case PermissaoEnum::PERMISSAO_COORDENADOR:
                $coord = new Coordenador();
                $coord->USU_ID = $this->USU_ID;
                $coord->save(false);
                break;

            case PermissaoEnum::PERMISSAO_PROFESSOR:
                $prof = new Professor();
                $prof->USU_ID = $this->USU_ID;
                $prof->save(false);
                break;
        }
    }

    /*public function init(){
        parent::init();
        if($this->scenario == Usuario::SCENARIO_PROFESSOR){
            $this->USU_PERMISSAO = PermissaoEnum::PERMISSAO_COORDENADOR;
        }
    }*/

    public function beforeSave(){
        if($this->isNewRecord){
            $senha = $this->gerarSenha();
            $this->enviarSenhaEmail($senha);
            $this->USU_SITUACAO = SituacaoEnum::ATIVO;
        }

        if($this->scenario == self::SCENARIO_ALTERAR_SENHA){
            $this->USU_SENHA = md5($this->_nova_senha);
        }

        return parent::beforeSave();
    }

    public function afterSave($insert, $changedAttributes){
        if($insert){
            $this->salvarUsuarioPorPermissao();
        }
    }

    public function getSexoText(){
        return SexoEnum::listar()[$this->USU_SEXO];
    }

    public function getPermissaoText(){
        return PermissaoEnum::listarSearch()[$this->USU_PERMISSAO];
    }

    public function getSituacaoText(){
        return SituacaoEnum::listar()[$this->USU_SITUACAO];
    }

    public function enviarSenhaEmail($senha){
        $subject = "SAESP (Sistema de Atividades Esportivas) - Credenciais de Acesso";
        
        if($this->scenario == self::SCENARIO_ESQUECI_SENHA){
            $subject = "SAESP (Sistema de Atividades Esportivas) - Alteração de senha";    
        }
        $mailer = Yii::$app->mailer;
        $mailer->compose(['html'=>'credencial'],['model'=>$this, 'senha'=>$senha])
        ->setFrom('email.sistemas@pmm.am.gov.br')
        ->setTo($this->USU_EMAIL)
        ->setSubject($subject)
        ->send();
    }

    public function gerarSenha(){
        
        /*Gera senha aleatória*/
        $senha = strtolower($this->getRandomString());
        /*Encripta para salvar*/
        $this->USU_SENHA = md5($senha); 
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

    public function validaNovaSenha($attribute, $params){
        
        if(($this->_nova_senha != null) && (strlen($this->_nova_senha) < 4 || strlen($this->_nova_senha) > 8 )){
            $this->addError($attribute,'Nova senha deve conter entre 4 e 8 caracteres.');
            return false;
        }       
        return true;
    }
    
    public function validaSenhaAntiga($attribute, $params){
        
        if ( ($this->_senha_atual !=  null) && ($this->USU_SENHA != md5($this->_senha_atual))){
            $this->addError($attribute,'Senha atual incorreta.');
            return false;
        }
        return true;
    }
}