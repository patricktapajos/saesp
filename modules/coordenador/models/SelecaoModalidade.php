<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\models\ModalidadeDataHora;
use Yii;

/**
 * This is the model class for table "SELECAO_MODALIDADE".
 *
 * @property string $SMOD_ID
 * @property string $SEL_ID
 * @property string $MOD_ID
 * @property string $PROF_ID
 */
class SelecaoModalidade extends \yii\db\ActiveRecord
{
    public $data;
    public $dias;
    public $complemento;

    const SCENARIO_VALIDACAO = 'validacaojson';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO_MODALIDADE';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_VALIDACAO] = ['complemento'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['complemento'],'required', 'on'=>[self::SCENARIO_VALIDACAO]],*/
            [['SEL_ID'],'required', 'on'=>['insert']],
            [['complemento'],'safe']
        ];
    }

    public function setComplemento($complemento){
        $this->complemento = $complemento;
    }

    public function getComplemento(){
        return $this->complemento;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SMOD_ID' => 'Código',
            'SEL_ID' => 'Seleção',
            'MOD_ID' => 'Modalidade',
            'complemento'=>'Complemento'
        ];
    }

    public function getModalidade(){
        return $this->hasOne(Modalidade::className(), ['MOD_ID'=>'MOD_ID']);
    }

    public function getModalidadeDataHora(){
        return $this->hasMany(ModalidadeDataHora::className(), ['SMOD_ID'=>'SMOD_ID']);
    }

    public function getDiasSemana(){

        $descricao = [];
        foreach ($this->getModalidadeDataHora()->all() as $id => $mdatahora) {
            
            $dias = [];
            $mdiasemana = $mdatahora->getModalidadeDiaSemana()->all();

            foreach ($mdiasemana as $key => $dia) {
                $dias[] = $dia->MDS_DESCRICAO;
            }
            
            $descricao[] =  implode(',',$dias) . ' / ' . $mdatahora->MDT_HORARIO_INICIO. ' - '. $mdatahora->MDT_HORARIO_FIM;
        }
        return implode(',',$descricao);
    }
}
