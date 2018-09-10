<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "MODALIDADE_DATAHORA".
 *
 * @property string $MDT_HORARIO_INICIO
 * @property string $MDT_QTDE_VAGAS
 * @property string $MDT_ID
 * @property string $MDT_HORARIO_FIM
 * @property string $SMOD_ID
 * @property string $PROF_ID
 *
 * @property SELECAOMODALIDADE $sMOD
 * @property MODALIDADEDIASEMANA[] $mODALIDADEDIASEMANAs
 */
class Modalidadedatahora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'MODALIDADE_DATAHORA';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MDT_HORARIO_INICIO', 'MDT_QTDE_VAGAS', 'MDT_STATUS', 'MDT_HORARIO_FIM', 'SMOD_ID', 'PROF_ID'], 'required'],
            [['MDT_QTDE_VAGAS', 'MDT_ID', 'SMOD_ID', 'PROF_ID'], 'number'],
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'string', 'max' => 5],
            [['MDT_ID'], 'unique'],
            [['SMOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SELECAOMODALIDADE::className(), 'targetAttribute' => ['SMOD_ID' => 'SMOD_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MDT_HORARIO_INICIO' => 'Hora Inicio',
            'MDT_HORARIO_FIM' => 'Horario  Fim',
            'MDT_QTDE_VAGAS' => 'Qtde  Vagas',
            'MDT_ID' => 'ID',
            'SMOD_ID' => 'Seleção Modalidade',
            'PROF_ID' => 'Professor',
            'MDT_STATUS' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSMOD()
    {
        return $this->hasOne(SELECAOMODALIDADE::className(), ['SMOD_ID' => 'SMOD_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMODALIDADEDIASEMANAs()
    {
        return $this->hasMany(MODALIDADEDIASEMANA::className(), ['MDT_ID' => 'MDT_ID']);
    }

    public function getPROFESSOR(){
        return $this->hasOne(PROFESSOR::className(), ['PROF_ID'=>'PROF_ID']);
    }
}
