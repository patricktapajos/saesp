<?php

namespace app\models;
use app\models\Coordenador;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\Modalidade;
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
 * @property  $
 */
class Cel extends \yii\db\ActiveRecord
{
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
            [['CEL_NOME','CRD_ID'], 'required'],
            [['CRD_ID'], 'number'],
            [['CEL_NOME', 'CEL_LATITUDE', 'CEL_LONGITUDE', 'CEL_LOGRADOURO', 'CEL_BAIRRO', 'CEL_COMPLEMENTO_END'], 'string', 'max' => 255],
            [['CEL_EMAIL'], 'string', 'max' => 150],
            [['CEL_TELEFONE'], 'string', 'max' => 10],
            [['CEL_CEP'], 'string', 'max' => 8],
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
            'CEL_BAIRRO' => 'Bairro',
            'CEL_COMPLEMENTO_END' => 'Complemento',
            'CRD_ID' => 'Coordenador',
        ];
    }

    public function getCoordenador(){
        return $this->hasOne(Coordenador::className(), ['CRD_ID'=>'CRD_ID']);
    }

    public function getSelecaomodalidades(){
        return $this->hasMany(SelecaoModalidade::className(), ['CEL_ID'=>'CEL_ID']);
    }

    public function getModalidades(){
        return $this->hasMany(Modalidade::className(), ['CEL_ID'=>'CEL_ID']);
    }
}
