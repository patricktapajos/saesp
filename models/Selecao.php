<?php

namespace app\models;
use app\models\SituacaoSelecaoEnum;
use Yii;

/**
 * This is the model class for table "SELECAO".
 *
 * @property string $SEL_ID
 * @property string $SEL_DT_INICIO
 * @property string $SEL_DT_FIM
 * @property string $SEL_SITUACAO
 */
class Selecao extends \app\components\SAESPActiveRecord
{
    //const SCENARIO_VAGAS_REMANESCENTES = 'vagasremanescentes';
    const SCENARIO_REABRIR_SELECAO = 'reabrirselecao';
    public $justificativa;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_REABRIR_SELECAO] = ['justificativa','SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEL_TITULO','SEL_DESCRICAO','SEL_SITUACAO'], 'required'],
            [['SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'], 'required','on'=>['default']],
            [['justificativa','SEL_DT_INICIO', 'SEL_DT_FIM'], 'required','on'=>self::SCENARIO_REABRIR_SELECAO],
            //[['SEL_DT_VR_INICIO','SEL_DT_VR_FIM'], 'required','on'=>self::SCENARIO_VAGAS_REMANESCENTES],
            [['SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'], 'string', 'max' => 10],
            [['SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'], 'date', 'format'=>'php:d/m/Y'],
            [['SEL_DT_INICIO', 'SEL_DT_FIM'], 'required', 'when' => function($model) {
                return $model->SEL_SITUACAO == SituacaoSelecaoEnum::INSCRICOES_ABERTAS || $model->scenario == Selecao::SCENARIO_REABRIR_SELECAO;
            }],
            [['SEL_SITUACAO'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEL_ID' => 'Código',
            'SEL_TITULO'=>'Título',
            'SEL_DESCRICAO'=>'Descrição',
            'SEL_DT_INICIO' => 'Data Início de Inscrições',
            'SEL_DT_FIM' => 'Data Fim de Inscrições',
            'SEL_DT_INICIO_CAD' => 'Data Início de cadastro',
            'SEL_DT_FIM_CAD' => 'Data Fim de cadastro',
            /*'SEL_DT_VR_INICIO' => 'Data Início Vagas Remanescentes',
            'SEL_DT_VR_FIM' => 'Data Fim Vagas Remanescentes',*/
            'SEL_SITUACAO' => 'Situação',
        ];
    }

    public function beforeValidate(){
        if($model->scenario == 'default'){
            $this->SEL_SITUACAO = SituacaoSelecaoEnum::CADASTRADO;
        }

        // if($model->scenario == self::SCENARIO_VAGAS_REMANESCENTES){
        //     $this->SEL_SITUACAO = SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ABERTO;
        // }

        return parent::beforeValidate();
    }

    public function beforeSave($insert){
        
        if($this->scenario == self::SCENARIO_REABRIR_SELECAO){
            $this->getLog()->log_justificativa = $this->justificativa;
            $this->getLog()->log_dados_antigos = json_encode($this->oldAttributes);
            //$this->getLog()->log_dados_novos = json_encode($this->attributes);
        }
        
        return parent::beforeSave($insert);
    }

    public function isCadastrado(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::CADASTRADO;
    }

    public function isParecer(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::PARECER_ABERTO;
    }

    public function isPreparadoInscricao(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::CADASTRADO || $this->SEL_SITUACAO == SituacaoSelecaoEnum::INSCRICOES_ABERTAS;
    }

    public function isPreparadoEncerrar(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::PARECER_ENCERRADO;
    }

    public function isPreparadoParecer(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::INSCRICOES_ENCERRADAS || $this->SEL_SITUACAO == SituacaoSelecaoEnum::PARECER_ABERTO;
    }

    public function isEncerrado(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::CONCLUIDO;
    }

    /*public function isVagasRemanescentes(){
        return $this->SEL_SITUACAO == SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ABERTO || $this->SEL_SITUACAO == SituacaoSelecaoEnum::VAGAS_REMANESCENTES_ABERTO;
    }*/

    public static function inscricoesAbertas(){
        return self::find()->where("SEL_SITUACAO=:SEL_SITUACAO and trunc(sysdate) between SEL_DT_INICIO and SEL_DT_FIM",['SEL_SITUACAO'=>SituacaoSelecaoEnum::INSCRICOES_ABERTAS])->one();

    }

     public static function cadastrarNaSelecao(){
        return self::find()->where("SEL_SITUACAO=:SEL_SITUACAO and trunc(sysdate) between SEL_DT_INICIO and SEL_DT_FIM",['SEL_SITUACAO'=>SituacaoSelecaoEnum::INSCRICOES_ABERTAS])->one();

    }

    public function getSituacaoText(){
        return SituacaoSelecaoEnum::listar()[$this->SEL_SITUACAO];
    }

    public static function getSelecaoAtiva(){
        return self::find()->where("SEL_SITUACAO = :SEL_SITUACAO",['SEL_SITUACAO'=>SituacaoSelecaoEnum::CADASTRADO])->one();
    }

    public static function cadastroCEL(){
        return self::find()->where("SEL_SITUACAO=:SEL_SITUACAO and trunc(sysdate) between SEL_DT_INICIO_CAD and SEL_DT_FIM_CAD",['SEL_SITUACAO'=>SituacaoSelecaoEnum::CADASTRADO])->one();
    }

    public function isUltimaCadastrada(){
        $sql = "SELECT MAX(SEL_ID) AS ULTIMA FROM SAESP.SELECAO";
        $command = Yii::$app->db->createCommand($sql);
        $resultado = $command->queryOne();
        return $this->SEL_ID == $resultado['ULTIMA'];
    }
}