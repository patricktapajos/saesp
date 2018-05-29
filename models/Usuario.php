<?php

namespace app\models;
use app\models\Administrador;
use app\models\Coordenador;
use app\models\Professor;
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
    const SCENARIO_PROFESSOR = 'professor';
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
        $scenarios [self::SCENARIO_PROFESSOR] = ['USU_NOME', 'USU_CPF','USU_EMAIL','USU_SEXO','USU_DT_NASC','USU_PERMISSAO','USU_SITUACAO'];
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
            [['USU_NOME', 'USU_CPF', 'USU_EMAIL', 'USU_SEXO', 'USU_DT_NASC','USU_PERMISSAO','USU_SITUACAO'], 'required'],
            [['USU_NOME', 'USU_EMAIL', 'USU_SENHA'], 'string', 'max' => 255],
            ['USU_EMAIL','email'],
            [['USU_EMAIL'],'validarHostEmail','on'=>['insert','']],
            [['USU_DT_NASC'], 'date'],
            [['USU_CPF'], CpfValidator::className()],
            [['USU_CPF'], 'string', 'max' => 14],
            [['USU_DT_NASC'], 'string', 'max' => 10],
            [['USU_DT_NASC'], 'date', 'format'=>'d/m/Y'],
            [['USU_SEXO'], 'string', 'max' => 15],
            [['USU_TELEFONE_1', 'USU_TELEFONE_2', 'USU_SITUACAO'], 'string', 'max' => 14],
            [['USU_PERMISSAO'], 'string', 'max' => 20],
            [['USU_CPF'], 'unique'],
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
            'USU_PERMISSAO' => 'Permissão', 
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

     /*
    * Fim das Relations
    *
    */

    public function validarHostEmail($attribute, $params){
        if(strpos( $this->$attribute, 'pmm.am.gov.br' ) !== false){            
            return true;
        }
        $this->addError($attribute, 'O email deve ser institucional (@pmm.am.gov.br)');
        return false;
    }

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
            $this->gerarSenha();
            $this->USU_SITUACAO = SituacaoEnum::ATIVO;
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
        return PermissaoEnum::listar()[$this->USU_PERMISSAO];
    }

    public function getSituacaoText(){
        return SituacaoEnum::listar()[$this->USU_SITUACAO];
    }

    /*public function enviarEmail(){
        
        $mailer=new CMailer();
        $mailer->AddAddress($this->USU_EMAIL);
                
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
}