<?php

namespace app\modules\aluno\models;
use app\modules\inscricao\models\Candidato;
use app\modules\inscricao\models\Inscricao;

use Yii;

/**
 * This is the model class for table "ALUNO".
 *
 * @property string $ALU_ESTADO_CIVIL
 * @property string $ALU_CPF
 * @property string $ALU_LOGRADOURO
 * @property string $ALU_COMPLEMENTO_END
 * @property string $ALU_CEP
 * @property string $ALU_BAIRRO
 * @property string $CAND_ID
 * @property string $ALU_NOME_EMERGENCIA
 * @property string $ALU_TEL_EMERGENCIA
 * @property string $ALU_NOME_RESPONSAVEL
 * @property string $ALU_TEM_COMORBIDADE
 * @property string $ALU_COMORBIDADE_DESC
 * @property string $ALU_TEM_MEDICACAO
 * @property string $ALU_MEDICACAO_DESC
 * @property string $ALU_OBSERVACOES
 * @property string $ALU_ID
 */
class Aluno extends \app\components\SAESPActiveRecord
{
    const SCENARIO_ALTERAR = 'alterar';
    
    public $justificativa;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ALUNO';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_ALTERAR] = ['justificativa','ALU_SITUACAO'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CAND_ID', 'ALU_ID'], 'required'],
            [['ALU_SITUACAO', 'justificativa'], 'required', 'on'=>self::SCENARIO_ALTERAR],
            [['CAND_ID', 'ALU_ID'], 'number'],
            [['ALU_ESTADO_CIVIL'], 'string', 'max' => 15],
            [['ALU_CPF'], 'string', 'max' => 11],
            [['ALU_LOGRADOURO', 'ALU_COMPLEMENTO_END', 'ALU_BAIRRO', 'ALU_NOME_EMERGENCIA', 'ALU_NOME_RESPONSAVEL'], 'string', 'max' => 255],
            [['ALU_CEP'], 'string', 'max' => 8],
            [['ALU_TEL_EMERGENCIA'], 'string', 'max' => 10],
            [['ALU_TEM_COMORBIDADE', 'ALU_TEM_MEDICACAO'], 'string', 'max' => 3],
            [['ALU_COMORBIDADE_DESC', 'ALU_MEDICACAO_DESC'], 'string', 'max' => 500],
            [['ALU_OBSERVACOES'], 'string', 'max' => 1500],
            [['ALU_ID'], 'unique'],
            [['CAND_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Candidato::className(), 'targetAttribute' => ['CAND_ID' => 'CAND_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CAND_ID' => 'Candidato',
            'INS_ID' => 'Inscrição',
            'ALU_SITUACAO' => 'Situação',
            'ALU_ID' => 'Alu  ID',
        ];
    }

    public function getCandidato()
    {
        return $this->hasOne(Candidato::className(), ['CAND_ID' => 'CAND_ID']);
    }

    public function getInscricao()
    {
        return $this->hasOne(Inscricao::className(), ['CAND_ID' => 'CAND_ID']);
    }

    public function beforeSave($insert){
        
        if($this->scenario == self::SCENARIO_ALTERAR){
            $this->getLog()->LOG_JUSTIFICATIVA = $this->justificativa;
            $this->getLog()->LOG_DADOS_ANTIGOS = json_encode($this->oldAttributes);
            //$this->getLog()->log_dados_novos = json_encode($this->attributes);
        }
        
        return parent::beforeSave($insert);
    }
}
