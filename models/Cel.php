<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cel".
 *
 * @property string $cel_nome
 * @property string $cel_email
 * @property string $cel_telefone
 * @property string $cel_latitude
 * @property string $cel_longitude
 * @property string $cel_logradouro
 * @property string $cel_cep
 * @property string $cel_bairro
 * @property string $cel_complemento_end
 * @property string $cel_id
 * @property string $crd_id
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
            [['cel_nome', 'crd_id'], 'required'],
            [['cel_id', 'crd_id'], 'number'],
            [['cel_nome', 'cel_latitude', 'cel_longitude', 'cel_logradouro', 'cel_bairro', 'cel_complemento_end'], 'string', 'max' => 255],
            [['cel_email'], 'string', 'max' => 18],
            [['cel_telefone'], 'string', 'max' => 10],
            [['cel_cep'], 'string', 'max' => 8],
            [['crd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coordenador::className(), 'targetAttribute' => ['crd_id' => 'crd_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crd_id' => 'Código',
            'cel_nome' => 'Nome',
            'cel_email' => 'Email',
            'cel_telefone' => 'Telefone',
            'cel_latitude' => 'Latitude',
            'cel_longitude' => 'Longitude',
            'cel_logradouro' => 'Logradouro',
            'cel_cep' => 'CEP',
            'cel_bairro' => 'Bairro',
            'cel_complemento_end' => 'Complemento',
            'crd_id' => 'Coordenador',
        ];
    }
}
