<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\modelsModalidadeDataHora;
use app\models\Professor;
use Yii;

/**
 * This is the model class for table "MODALIDADE_DATAHORA".
 *
 * @property string $MDT_DIA_SEMANA
 * @property string $MDT_HORARIO_INICIO
 * @property string $MDT_QTDE_VAGAS
 * @property string $MDT_ID
 * @property string $MDT_HORARIO_FIM
 * @property string $SMOD_ID
 */
class ModalidadeDataHora extends \yii\db\ActiveRecord
{

    public $dias;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MODALIDADE_DATAHORA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MDT_QTDE_VAGAS', 'MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM', 'PROF_ID', 'dias'], 'required'],
            [['MDT_QTDE_VAGAS', 'SMOD_ID','PROF_ID'], 'number'],
            [['MDT_DIA_SEMANA'], 'string', 'max' => 18],
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'string', 'max' => 5],
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'validarValorHorario'],
            [['MDT_HORARIO_FIM'], 'validarHorario'],
            [['PROF_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['PROF_ID' => 'PROF_ID']],
            /*[['SMOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SelecaoModalidade::className(), 'targetAttribute' => ['SMOD_ID' => 'SMOD_ID']],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MDT_DIA_SEMANA' => 'Dia da Semana',
            'MDT_HORARIO_INICIO' => 'Início',
            'MDT_QTDE_VAGAS' => 'Qtde. de Vagas',
            'MDT_ID' => 'Modalidade',
            'PROF_ID' => 'Professor',
            'MDT_HORARIO_FIM' => 'Fim',
            'SMOD_ID' => 'Seleção/Modalidade',
        ];
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

    public function getProfessor(){
        return $this->hasOne(Professor::className(), ['PROF_ID'=>'PROF_ID']);
    }

     public function getSelecaoModalidade(){
        return $this->hasMany(SelecaoModalidade::className(), ['SMOD_ID'=>'SMOD_ID']);
    }

    public function getModalidadeDiaSemana(){
        return $this->hasMany(ModalidadeDiaSemana::className(), ['MDT_ID'=>'MDT_ID']);
    }
}