<?php

namespace app\models;
use app\models\Coordenador;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\Modalidade;
use app\models\SituacaoEnum;
use Yii;

/**
 * This is the model class for table "cel".
 *
 * @property string $CEL_NOME
 * @property string $CEL_EMAIL
 * @property string $CEL_TELEFONE
 * @property string $CEL_LATITUDE
 * @property string $CEL_LONGITUDE
 * @property string $CEL_LOGRADOURO
 * @property string $CEL_CEP
 * @property string $CEL_BAIRRO
 * @property string $CEL_COMPLEMENTO_END
 * @property string $cel_id
 * @property string $CRD_ID
 * @property string $CEL_STATUS
 * @property  $
 */
class Cel extends \yii\db\ActiveRecord
{

    public $_nome_coordenador;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CEL';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CEL_NOME','CEL_STATUS','_nome_coordenador'], 'required'],
            [['CRD_ID'], 'validarCoordenador'],
            [['CRD_ID'], 'number'],
            [['CEL_NOME', 'CEL_LATITUDE', 'CEL_LONGITUDE', 'CEL_LOGRADOURO', 'CEL_BAIRRO', 'CEL_COMPLEMENTO_END','CEL_TELEFONE'], 'string', 'max' => 255],
            [['CEL_EMAIL'], 'string', 'max' => 150],
            [['CEL_CEP'], 'string', 'max' => 9],
            [['CRD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Coordenador::className(), 'targetAttribute' => ['CRD_ID' => 'CRD_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CEL_ID' => 'Código',
            'CEL_NOME' => 'Nome',
            'CEL_EMAIL' => 'Email',
            'CEL_TELEFONE' => 'Telefone',
            'CEL_LATITUDE' => 'Latitude',
            'CEL_LONGITUDE' => 'Longitude',
            'CEL_LOGRADOURO' => 'Logradouro',
            'CEL_CEP' => 'CEP',
            'CEL_STATUS' => 'Situação',
            'CEL_BAIRRO' => 'Bairro',
            'CEL_COMPLEMENTO_END' => 'Complemento',
            'CRD_ID' => 'Coordenador',
            '_nome_coordenador' => 'Coordenador',
        ];
    }

    public function validarCoordenador($attribute, $params){
        
        $celc = Cel::find()->where(['CRD_ID'=>$this->$attribute])->one();
        if($celc){

            if($celc->CEL_ID == $this->CEL_ID){
                return true;
            }
            $this->addError($attribute,'Coordenador já relacionado a um CEL.');
            return false;
        }
        return true;
    }

    public function beforeValidate(){
        $this->CEL_CEP = preg_replace('/[^0-9]/', '', $this->CEL_CEP);
        $this->CEL_TELEFONE = preg_replace('/[^0-9]/', '', $this->CEL_TELEFONE);
        return parent::beforeValidate();
    }

    /*public function init(){
        parent::init();
        $this->CEL_STATUS = SituacaoEnum::ATIVO;
    }*/


    public function getCoordenador(){
        return $this->hasOne(Coordenador::className(), ['CRD_ID'=>'CRD_ID']);
    }

    public function getModalidades(){
        return $this->hasMany(Modalidade::className(), ['CEL_ID'=>'CEL_ID'])->orderBy(['MOD_NOME' => SORT_ASC]);
    }

    public function afterFind(){

        $this->_nome_coordenador = $this->coordenador->usuario->USU_NOME;

        return parent::afterFind();
    }
}
