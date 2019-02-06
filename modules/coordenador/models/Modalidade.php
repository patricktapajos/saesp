<?php

namespace app\modules\coordenador\models;
use app\models\Cel;
use app\modules\coordenador\models\Nivel;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "MODALIDADE".
 *
 * @property string $MOD_NOME
 * @property string $MOD_DESCRICAO
 * @property string $MOD_ID
 * @property string $CEL_ID
 */
class Modalidade extends \yii\db\ActiveRecord
{
    public $photo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MODALIDADE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MOD_ID'], 'unique', 'message'=>'Modalidade com este nome já cadastrada'],
            [['MOD_NOME', 'MOD_DESCRICAO','CAT_ID'], 'required'],
            [['MOD_NOME', 'MOD_DESCRICAO'], 'string', 'max' => 255],
            [['MOD_LIMITE_IDADE'], 'string', 'max' => 1],
            [['MOD_IDADE_MIN', 'MOD_IDADE_MAX','NIV_ID'], 'number'],
            [['CEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Cel::className(), 'targetAttribute' => ['CEL_ID' => 'CEL_ID']],
            [['MOD_URL_FOTO'], 'file', 'skipOnError' => true, 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MOD_NOME' => 'Nome',
            'MOD_DESCRICAO' => 'Descrição',
            'MOD_ID' => 'Código',
            'CEL_ID' => 'CEL',
            'CAT_ID' => 'Categoria',
            'NIV_ID' => 'Nível',
            'MOD_URL_FOTO' => 'Ícone',
            'MOD_IDADE_MIN' => 'Idade Mínima',
            'MOD_IDADE_MAX' => 'Idade Máxima',

        ];
    }

    public function getCel(){
        return $this->hasOne(Cel::className(), ['CEL_ID'=>'CEL_ID']);
    }

    public function getSelecaoModalidades(){
        return $this->hasMany(SelecaoModalidade::className(), ['MOD_ID'=>'MOD_ID']);
    }

    public function getCategoria(){
        return $this->hasOne(Categoria::className(), ['CAT_ID' => 'CAT_ID']);
    }

    public function getNivel(){
        return $this->hasOne(Nivel::className(), ['NIV_ID' => 'NIV_ID']);
    }

    public function afterFind(){
        $this->photo = $this->MOD_URL_FOTO;
        return parent::afterFind();
    }

    public function setArquivo(){
        $this->MOD_URL_FOTO = UploadedFile::getInstance($this, 'MOD_URL_FOTO');
    }

    public function upload(){
        if($this->MOD_URL_FOTO != null){
            $this->MOD_URL_FOTO->saveAs('uploads/' . $this->MOD_URL_FOTO->baseName . '.' . $this->MOD_URL_FOTO->extension);
        }
    }

    public function getUrlFoto(){
        $photo = '/images/semicone.png';
        if($this->MOD_URL_FOTO){
            $photo = '/uploads/'.$this->MOD_URL_FOTO;
        }
        return Yii::$app->request->baseUrl.$photo;
    }

    public function beforeSave($insert){
        
        if(!$insert){
            if($this->MOD_URL_FOTO == null){
                $this->MOD_URL_FOTO = $this->photo;
            }
        }

        return parent::beforeSave($insert);
    }
}