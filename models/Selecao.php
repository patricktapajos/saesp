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
class Selecao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEL_TITULO','SEL_DESCRICAO'], 'required'],
            [['SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'], 'string', 'max' => 10],
            [['SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_DT_INICIO_CAD','SEL_DT_FIM_CAD'], 'date', 'format'=>'d/m/Y'],
            [['SEL_DT_INICIO', 'SEL_DT_FIM'], 'required', 'when' => function($model) {
                return $model->SEL_SITUACAO == SituacaoSelecaoEnum::INSCRICOES_ABERTAS;
            }],
            [['SEL_DT_INICIO_CAD', 'SEL_DT_FIM_CAD'], 'required', 'when' => function($model) {
                return $model->SEL_SITUACAO == SituacaoSelecaoEnum::CADASTRADO;
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
            'SEL_SITUACAO' => 'Situação',
        ];
    }

    public function init(){
        parent::init();
        if($model->scenario != ''){
            $this->SEL_SITUACAO = SituacaoSelecaoEnum::CADASTRADO;
        }
    }

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
}