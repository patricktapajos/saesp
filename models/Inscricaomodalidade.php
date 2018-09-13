<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "INSCRICAO_MODALIDADE".
 *
 * @property string $IMO_ID
 * @property string $INS_ID
 * @property string $MDT_ID
 * @property string $IMO_STATUS ATIVO, INATIVO, DESISTÊNCIA
 *
 * @property INSCRICAO $iNS
 */
class Inscricaomodalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'INSCRICAO_MODALIDADE';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['INS_ID', 'MDT_ID'], 'required'],
            [['IMO_ID', 'INS_ID', 'MDT_ID'], 'number'],
            [['IMO_STATUS'], 'string', 'max' => 20],
            [['IMO_ID'], 'unique'],
            [['INS_ID'], 'exist', 'skipOnError' => true, 'targetClass' => INSCRICAO::className(), 'targetAttribute' => ['INS_ID' => 'INS_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IMO_ID' => 'ID',
            'INS_ID' => 'Inscrição',
            'MDT_ID' => 'Modalidade',
            'IMO_STATUS' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getINS()
    {
        return $this->hasOne(INSCRICAO::className(), ['INS_ID' => 'INS_ID']);
    }

    public function getMOD_DT_HR()
    {
        return $this->hasOne(Modalidadedatahora::className(), ['MDT_ID' => 'MDT_ID']);
    }

    public function getModalidadedatahora(){
        return $this->hasMany(Modalidadedatahora::className(), ['MDT_ID'=>'MDT_ID']);
    }
}
