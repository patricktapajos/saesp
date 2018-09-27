<?php

namespace app\modules\inscricao\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "INSCRICAO_DOCUMENTO".
 *
 * @property string $DOC_ID
 * @property string $DOC_RG_URL
 * @property string $DOC_CRESID_URL
 * @property string $DOC_CPF_URL
 * @property string $DOC_ATESTADO_URL
 * @property string $DOC_LAUDO_PCD_URL
 * @property string $DOC_LAUDO_DERMATO_URL
 * @property string $DOC_DECLARACAO_MENOR
 * @property string $DOC_ATESTADO_IDOSO
 */
class InscricaoDocumento extends \yii\db\ActiveRecord
{
    public $DOC_RG_URL_AUX;
    public $DOC_CPF_URL_AUX;
    public $DOC_CRESID_URL_AUX;
    public $DOC_LAUDO_PCD_URL_AUX;
    public $DOC_LAUDO_DERMATO_URL_AUX;
    public $DOC_DECLARACAO_MENOR_AUX;
    public $DOC_ATESTADO_IDOSO_AUX;
    public $DOC_ATESTADO_URL_AUX;


    public $camposfotos = [
        'DOC_RG_URL_AUX'=>'DOC_RG_URL',
        'DOC_CPF_URL_AUX'=>'DOC_CPF_URL',
        'DOC_CRESID_URL_AUX'=>'DOC_CRESID_URL',
        'DOC_LAUDO_PCD_URL_AUX'=>'DOC_LAUDO_PCD_URL',
        'DOC_LAUDO_DERMATO_URL_AUX'=>'DOC_LAUDO_DERMATO_URL',
        'DOC_DECLARACAO_MENOR_AUX'=>'DOC_DECLARACAO_MENOR',
        'DOC_LAUDO_DERMATO_URL_AUX'=>'DOC_LAUDO_DERMATO_URL',
        'DOC_ATESTADO_IDOSO_AUX'=>'DOC_ATESTADO_IDOSO',
        'DOC_ATESTADO_URL_AUX'=>'DOC_ATESTADO_URL'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'INSCRICAO_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            [['DOC_RG_URL', 'DOC_CRESID_URL', 'DOC_CPF_URL'], 'required','on'=>'default'],
            [['DOC_RG_URL', 'DOC_CRESID_URL', 'DOC_CPF_URL','DOC_DECLARACAO_MENOR'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
            ['DOC_LAUDO_PCD_URL', 'required', 'when'=>function($model){return false;}, 'whenClient' => "laudoPCD"],
            ['DOC_ATESTADO_URL', 'required', 'when'=>function($model){return false;}, 'whenClient'  => "atestadoComorbidade"],
            ['DOC_ATESTADO_IDOSO', 'required', 'when'=>function($model){return false;},'whenClient' => "atestadoIdoso"],
            ['DOC_DECLARACAO_MENOR', 'required', 'when'=>function($model){return false;},'whenClient' => "atestadoMenor"],
            [['DOC_ID'], 'unique'],
            [['DOC_RG_URL_AUX','DOC_CPF_URL_AUX','DOC_CRESID_URL_AUX','DOC_LAUDO_PCD_URL_AUX','DOC_LAUDO_DERMATO_URL_AUX','DOC_DECLARACAO_MENOR_AUX','DOC_LAUDO_DERMATO_URL_AUX','DOC_ATESTADO_IDOSO_AUX','DOC_ATESTADO_URL_AUX'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'DOC_ID' => 'Código',
            'DOC_RG_URL' => 'RG',
            'DOC_CRESID_URL' => 'Comprovante de Residência',
            'DOC_CPF_URL' => 'CPF',
            'DOC_ATESTADO_URL' => 'Atestado',
            'DOC_LAUDO_PCD_URL' => 'Laudo PCD',
            'DOC_LAUDO_DERMATO_URL' => 'Laudo Dermatológico',
            'DOC_DECLARACAO_MENOR' => 'Declaração de Menor',
            'DOC_ATESTADO_IDOSO' => 'Atestado Cardiológico',
        ];
    }


     public function afterFind(){
        foreach ($this->camposfotos as $key=>$value) {
            $this->{$key} = $this->{$value};
        }        
    }

    /*public function afterValidate($insert){
         if(!$insert){
            foreach ($this->camposfotos as $key=>$related) {
                $this->{$key} = $this->{$related};    
            }
        }
    }*/

    /*public function beforeSave($insert){
        
        if(!$insert){
             foreach ($this->camposfotos as $key=>$related) {
                $this->{$related} = $this->{$key};    
            }
        }

       return parent::beforeSave();
    }*/

    public function getUrlFoto($campo){
        $img = '/images/semdoc2.png';
        $pdf = '/images/pdf.png';

        if($this->{$campo} != null && preg_match('/[jpg][png]/',$this->{$campo})){
            $img = '/uploads/'.$this->{$campo};
        }else if($this->{$campo} != null && preg_match('/pdf/',$this->{$campo})){
            $img = $pdf;
        }

        return Yii::$app->request->baseUrl.$img;
    }

    public function getUrlDocumento($campo){
        $img = '/images/semdoc2.png';
        if($this->{$campo}){
           $img = '/uploads/'.$this->{$campo};
        }

        return Yii::$app->request->baseUrl.$img;
    }

    public function setArquivos(){
        foreach ($this->camposfotos as $n=>$campo) {
            if(UploadedFile::getInstance($this, $campo) instanceof UploadedFile){
                $this->{$campo} = UploadedFile::getInstance($this, $campo);
            }else{
                $this->{$campo} = $this->{$n};
            }
        }
    }

    public function upload(){
        foreach ($this->camposfotos as $n=>$campo) {
            if(UploadedFile::getInstance($this, $campo) instanceof UploadedFile){
                $this->{$campo}->saveAs('uploads/' . $this->{$campo}->baseName . '.' . $this->{$campo}->extension);
            }
        }
    }

    public function getDocumentosImagem(){
        
        $docs = [];
        foreach ($this->camposfotos as $n=>$campo) {
            //var_dump(preg_match('/[jpg][png]/',$this->{$campo}));die;
          if($this->{$campo} != null && preg_match('/[jpg][png]/',$this->{$campo})){
            $docs[] = $campo;  
          }
        }
        return $docs;
    }

    public function getDocumentosPdf(){
        $docs = [];
        foreach ($this->camposfotos as $n=>$campo) {
          if($this->{$campo} != null && preg_match('/pdf/',$this->{$campo})){
            $docs[] = $campo;  
          }
        }
        return $docs;
    }
}