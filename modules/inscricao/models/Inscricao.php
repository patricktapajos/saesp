<?php

namespace app\modules\inscricao\models;
use app\models\SituacaoInscricaoEnum;
use app\modules\inscricao\models\InscricaoDocumento;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\Selecao;
use Yii;

/**
 * This is the model class for table "INSCRICAO".
 *
 * @property string $CAND_ID
 * @property string $INS_ID
 * @property string $INS_PCD
 * @property string $INS_SITUACAO
 * @property string $INS_DT_CADASTRO
 * @property string $SEL_ID
 */
class Inscricao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'INSCRICAO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CAND_ID', 'INS_ID', 'SEL_ID'], 'number'],
            [['INS_PCD'], 'string', 'max' => 3],
            [['INS_SITUACAO'], 'string', 'max' => 20],
            [['INS_DT_CADASTRO'], 'string', 'max' => 7],
            [['INS_ID'], 'unique'],
            /*[['SEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Selecao::className(), 'targetAttribute' => ['SEL_ID' => 'SEL_ID']],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'INS_ID' => 'Código',
            'CAND_ID' => 'Candidato',
            'INS_PCD' => 'PcD',
            'INS_SITUACAO' => 'Situação',
            'INS_DT_CADASTRO' => 'Data de Cadastro',
            'SEL_ID' => 'Seleção',
            'INS_NUM_INSCRICAO' => 'Nº de Inscrição'
        ];
    }

   public function beforeSave(){
        if($this->isNewRecord){
            $this->INS_SITUACAO = SituacaoInscricaoEnum::AGUARDE;
        }
        return parent::beforeSave();
    }

    public function afterSave($insert, $changedAttributes){
        if($insert){
            $this->INS_NUM_INSCRICAO = date('Y').str_pad($this->INS_ID, 6, '0', STR_PAD_LEFT);
            $this->save();
        }
    }

    public function getInscricaodocumento(){
        return $this->hasOne(InscricaoDocumento::className(), ['INS_ID'=>'INS_ID']);
    }

    public function getInscricaomodalidade(){
        return $this->hasMany(InscricaoModalidade::className(), ['INS_ID'=>'INS_ID']);
    }
}