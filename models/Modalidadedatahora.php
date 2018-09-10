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

    public function setDias($dias){
        $this->dias = $dias;
    }

    public function getDias(){
        return $this->dias;
    }

    public function validarValorHorario($attribute, $params){
        $horario = explode(':', $this->$attribute);

        $hora = (int)$horario[0];
        $minuto = (int)$horario[1];

        if(($hora < 0 || $hora > 23) || ($minuto < 0 || $minuto > 59)){
            $this->addError($attribute, 'Horário inválido. Escolha um horário entre 00:00 e 23:59');
            return false;
        }

        return true;
    }

    public function validarHorario($attribute, $params){
        $hora_inicio = preg_replace('/[^0-9]/', '', $this->MDT_HORARIO_INICIO);
        $hora_fim = preg_replace('/[^0-9]/', '', $this->$attribute);

        if((int)$hora_inicio > (int)$hora_fim){
            $this->addError($attribute, 'Horário final não pode ser menor que o horário inicial');
            return false;
        }

        return true;
    }

    public function getSelecaoModalidade(){
        return $this->hasMany(SelecaoModalidade::className(), ['SMOD_ID'=>'SMOD_ID']);
    }

    public function getModalidadeDiaSemana(){
        return $this->hasMany(ModalidadeDiaSemana::className(), ['MDT_ID'=>'MDT_ID']);
    }

    public function getQtdeInscritos(){
        return  $this->hasMany(InscricaoModalidade::className(), ['MDT_ID'=>'MDT_ID'])->count();
    }

    public function getDiasSemana(){
        $dias = [];
        $mdiasemana = $this->getModalidadeDiaSemana()->all();

        foreach ($mdiasemana as $key => $dia) {
            $dias[] = $dia->MDS_DESCRICAO;
        }
        return implode(', ',$dias);
    }

    public function getHorario(){
        return $this->MDT_HORARIO_INICIO. ' - '. $this->MDT_HORARIO_FIM;
    }
}
