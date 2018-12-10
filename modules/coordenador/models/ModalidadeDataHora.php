<?php

namespace app\modules\coordenador\models;
use app\modules\inscricao\models\InscricaoModalidade;
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
    public $quadro_modalidades;
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
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'string', 'max' => 5],
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'validarValorHorario'],
            [['MDT_HORARIO_FIM'], 'validarHorario'],
            [['PROF_ID'], 'validarRepeticaoHorario'],
            
            /*[['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM','dias','PROF_ID'], 'unique', 'message'=>'Dados já cadastrados'],*/
            [['PROF_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['PROF_ID' => 'PROF_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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

        /*if(((int)$hora_inicio) - ((int)$hora_fim) <= 30){            
            $this->addError($attribute, 'Este curso possui menos de 30 minutos?');
            return false;
        }*/

        return true;
    }

    public function validarRepeticaoHorario($attribute, $params){
        $cont = 0;
        foreach($this->quadro_modalidades as $infos){
            foreach($infos as $info){
                if(count($this->getDias()) > 0){
                    if($this->$attribute == $info['PROF_ID']  && $this->verificaHorariosIguais($info)){
                        $cont++;  
                    }
                }
            }
        }

        if($cont >= 2){
            $this->addError($attribute, 'Professor não pode ser relacionado mais de uma vez em dia/hora da semana');
            return false;
        }
        return true;
    }

    function verificaHorariosIguais($info){
       
        $maior = $this->getDias();
        $menor = $info['dias'];
        
        $result = array_intersect($menor, $maior);

        $menor = $result;
        $maior = $result;
    

        $contInt = 0;
        for ($i=0; $i <= count($menor) ; $i++) { 
            if(
                $menor[$i] == $maior[$i] && ($this->MDT_HORARIO_INICIO == $info['MDT_HORARIO_INICIO'] || $this->MDT_HORARIO_FIM == $info['MDT_HORARIO_FIM']))
            {
                $contInt++;
            }
        }

        if($contInt > 1){
            return true;
        }
        return false;
    }

    /*function verificarDiasIguais($array1, $array2){
        $arrayIntersect1 = array_uintersect($array1, $array2, function($v1, $v2) {        
                if ($v1===$v2) {
                    return 0;
                }
                if ($v1 > $v2) return 1;
                return -1;
            }
        );

        $arrayIntersect2 = array_uintersect($array2, $array1, function($v1, $v2) {        
                if ($v1===$v2) {
                    return 0;
                }
                if ($v1 > $v2) return 1;
                return -1;
            }
        );
    
        if($array1 === $arrayIntersect1 && $array2 === $arrayIntersect2) {
            return true;
        } 
        return false;
    }*/

    public function getProfessor(){
        return $this->hasOne(Professor::className(), ['PROF_ID'=>'PROF_ID']);
    }

    public function getSelecaoModalidade(){
        return $this->hasOne(SelecaoModalidade::className(), ['SMOD_ID'=>'SMOD_ID']);
    }

    /*public function getSelecaoModalidade(){
        return $this->hasMany(SelecaoModalidade::className(), ['SMOD_ID'=>'SMOD_ID']);
    }*/

    public function getModalidadeDiaSemana(){
        return $this->hasMany(ModalidadeDiaSemana::className(), ['MDT_ID'=>'MDT_ID']);
    }

    public function getInscricaoModalidade(){
        return $this->hasOne(InscricaoModalidade::className(), ['MDT_ID'=>'MDT_ID']);
    }

    public function getQtdeInscritos(){
        return $this->hasMany(InscricaoModalidade::className(), ['MDT_ID'=>'MDT_ID'])->count();
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