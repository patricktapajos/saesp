<?php

namespace app\modules\inscricao\models;
use app\models\Usuario;
use app\models\EstadoCivilEnum;
use app\models\SimNaoEnum;
use app\modules\inscricao\models\Inscricao;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "CANDIDATO".
 *
 * @property string $CAND_ESTADO_CIVIL
 * @property string $CAND_CPF
 * @property string $CAND_LOGRADOURO
 * @property string $CAND_COMPLEMENTO_END
 * @property string $CAND_CEP
 * @property string $CAND_BAIRRO
 * @property string $CAND_ID
 * @property integer $USU_ID
 * @property string $CAND_NOME_EMERGENCIA
 * @property string $CAND_TEL_EMERGENCIA
 * @property string $CAND_NOME_RESPONSAVEL
 * @property string $CAND_TEM_COMORBIDADE
 * @property string $CAND_COMORBIDADE_DESC
 * @property string $CAND_TEM_MEDICACAO
 * @property string $CAND_MEDICACAO_DESC
 * @property string $CAND_OBSERVACOES
 */
class Candidato extends \yii\db\ActiveRecord
{
    /* Lista de modalidades selecionadas, atributo utilizado para validação */
    public $modalidades;
    public $modalidade;

    /* Atributo utilizado para verificação de alteração de foto do candidato */
    public $photo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CANDIDATO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CAND_FOTO'], 'file', 'skipOnError' => true, 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['CAND_ESTADO_CIVIL','CAND_CEP','CAND_LOGRADOURO','CAND_BAIRRO'], 'required','message'=>'{attribute} obrigatório'],
            [['modalidades'], 'required','message'=>'{attribute} obrigatório'],
            
            ['CAND_NOME_RESPONSAVEL', 'required', 'when' => function($model) {
                return $model->CAND_MENOR_IDADE == 'SIM';
            },'whenClient' => "menorIdade"],

            ['CAND_PCD_DESC', 'required', 'when' => function($model) {
                return $model->CAND_PCD == 'SIM';
            },'whenClient' => "pcd"],

            ['CAND_MEDICACAO_DESC', 'required', 'when' => function($model) {
                return $model->CAND_TEM_MEDICACAO == 'SIM';
            },'whenClient' => "medicacao"],
            
            ['CAND_COMORBIDADE_DESC', 'required', 'when' => function($model) {
                return $model->CAND_TEM_COMORBIDADE == 'SIM';
            },'whenClient' => "comorbidade"],

            [['CAND_ESTADO_CIVIL'], 'string', 'max' => 15],
            [['CAND_CPF'], 'string', 'max' => 14],
            [['CAND_LOGRADOURO', 'CAND_COMPLEMENTO_END', 'CAND_BAIRRO', 'CAND_NOME_EMERGENCIA', 'CAND_NOME_RESPONSAVEL'], 'string', 'max' => 255],
            [['CAND_CEP'], 'string', 'max' => 10],
            [['CAND_TEL_EMERGENCIA'], 'string', 'max' => 15],
            [['CAND_TEM_COMORBIDADE', 'CAND_TEM_MEDICACAO', 'CAND_PCD', 'CAND_MENOR_IDADE', 'CAND_IDOSO'], 'string', 'max' => 3],
            [['CAND_COMORBIDADE_DESC', 'CAND_MEDICACAO_DESC','CAND_PCD_DESC'], 'string', 'max' => 500],
            [['CAND_OBSERVACOES'], 'string', 'max' => 1500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CAND_ID' => 'Código',
            'CAND_ESTADO_CIVIL' => 'Estado  Civil',
            'CAND_CPF' => 'CPF',
            'CAND_LOGRADOURO' => 'Logradouro',
            'CAND_COMPLEMENTO_END' => 'Complemento',
            'CAND_CEP' => 'CEP',
            'CAND_BAIRRO' => 'Bairro',
            'USU_ID' => 'Usuário',
            'CAND_NOME_EMERGENCIA' => 'Em caso de emergência, chamar?',
            'CAND_TEL_EMERGENCIA' => 'Número de Emergência',
            'CAND_NOME_RESPONSAVEL' => 'Nome do Responsavel',
            'CAND_TEM_COMORBIDADE' => 'Possui alguma comorbidade?',
            'CAND_COMORBIDADE_DESC' => 'Comorbidade(s)',
            'CAND_TEM_MEDICACAO' => 'Ingere algum medicamento?',
            'CAND_MEDICACAO_DESC' => 'Medicamento(s)',
            'CAND_OBSERVACOES' => 'Observações',
            'CAND_PCD' => 'PcD (Pessoa Com Deficiência)',
            'CAND_PCD_DESC' => 'Descrição da Deficiência',
            'CAND_MENOR_IDADE' => 'Candidato Menor de Idade',
            'CAND_IDOSO' => 'Candidato Idoso',
            'CAND_FOTO' => 'Foto'
        ];
    }

    public function init(){
        $this->CAND_MENOR_IDADE = 'NAO';
        $this->CAND_IDOSO = 'NAO';
        $this->CAND_TEM_COMORBIDADE = 'NAO';
        $this->CAND_TEM_MEDICACAO = 'NAO';
        $this->CAND_PCD = 'NAO';
    }

     public function beforeValidate(){
        $this->CAND_CEP = preg_replace('/[^0-9]/', '', $this->CAND_CEP);
        return parent::beforeValidate();
    }

    public function getUsuario(){
        return $this->hasOne(Usuario::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getInscricao(){
        return $this->hasOne(Inscricao::className(), ['CAND_ID'=>'CAND_ID']);
    }

    public function getCandidatoDocumento(){
        return $this->hasOne(CandidatoDocumento::className(), ['CAND_ID'=>'CAND_ID']);
    }

    public function setArquivo(){
        $this->CAND_FOTO = UploadedFile::getInstance($this, 'CAND_FOTO');
    }

    public function upload(){
        if($this->CAND_FOTO != null){
            $this->CAND_FOTO->saveAs('uploads/' . $this->CAND_FOTO->baseName . '.' . $this->CAND_FOTO->extension);
        }
    }

    public function afterFind(){
        $this->photo = $this->CAND_FOTO;
    }

    public function getEstadoCivilText(){
        return EstadoCivilEnum::listar()[$this->CAND_ESTADO_CIVIL];
    }

    public function getSimNaoText($campo){
        return SimNaoEnum::listar()[$this->$campo];
    }

    /*public function afterValidate(){
         if(!$insert){
            if($this->CAND_FOTO == null){
                $this->CAND_FOTO = $this->photo;
            }
        }
    }*/

    public function beforeSave($insert){
        
        if(!$insert){
            if($this->CAND_FOTO == null){
                $this->CAND_FOTO = $this->photo;
            }
        }

        return parent::beforeSave();
    }

    public function getUrlFoto(){
        $photo = '/images/semfoto.png';
        if($this->CAND_FOTO){
            $photo = '/uploads/'.$this->CAND_FOTO;
        }
        return Yii::$app->request->baseUrl.$photo;
    }
}