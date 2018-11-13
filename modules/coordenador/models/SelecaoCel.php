<?php

namespace app\modules\coordenador\models;
use app\models\Selecao;
use app\models\Cel;
use yii\helpers\ArrayHelper;
use app\models\SituacaoSelecaoEnum;
use app\modules\coordenador\models\SelecaoModalidade;
use Yii;

/**
 * This is the model class for table "SELECAO_CEL".
 *
 * @property string $SCEL_ID
 * @property string $CEL_ID
 * @property string $SEL_ID
 */
class SelecaoCel extends \yii\db\ActiveRecord
{
    const SCENARIO_VALIDACAO = 'validacaojson';
    public $complementoexclusao;
    public $modalidades;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO_CEL';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_VALIDACAO] = ['SEL_ID','modalidades'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEL_ID'], 'required', 'on'=>['insert',self::SCENARIO_VALIDACAO]],
            [['modalidades'], 'validarModalidades', 'on'=>[self::SCENARIO_VALIDACAO]],
            [['SCEL_ID', 'CEL_ID', 'SEL_ID'], 'number'],
            [['SEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Selecao::className(), 'targetAttribute' => ['SEL_ID' => 'SEL_ID']],
            [['SEL_ID','modalidades','complementoexclusao'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SCEL_ID' => 'Código',
            'CEL_ID' => 'CEL',
            'SEL_ID' => 'Seleção',
        ];
    }

    public function setModalidades($modalidades){
        $this->modalidades = $modalidades;
    }

    public function getModalidades(){
        return $this->modalidades;
    }

     public function validarModalidades($attribute, $params){
        foreach ($this->getModalidades() as $modalidade) {
            if(count($modalidade['complemento']) > 0){
                return true;
            }
        }
        $this->addError($attribute, 'É necessário preencher ao menos uma modalidade.');
        return false;
    }

    public function init(){
        $this->CEL_ID = Yii::$app->user->identity->cel_id;
        return parent::init();
    }

    public static function selecoesAtivas(){
        return ArrayHelper::map(Selecao::find()->andWhere("SEL_SITUACAO =:SEL_SITUACAO",[':SEL_SITUACAO'=>SituacaoSelecaoEnum::CADASTRADO])->all(), 'SEL_ID','SEL_DESCRICAO');
    }

    public function getSelecao(){
        return $this->hasOne(Selecao::className(), ['SEL_ID'=>'SEL_ID']);
    }

    public function getSelecaoModalidade(){
        return $this->hasMany(SelecaoModalidade::className(), ['SCEL_ID'=>'SCEL_ID']);
    }

    public function getCel(){
        return $this->hasOne(Cel::className(), ['CEL_ID'=>'CEL_ID']);
    }

    public static function listar(){
        return ArrayHelper::map(self::find()->with('selecao')->andWhere("CEL_ID =:CEL_ID",[':CEL_ID'=>Yii::$app->user->identity->cel_id])->all(), 'selecao.SEL_ID','selecao.SEL_DESCRICAO');
    }
}