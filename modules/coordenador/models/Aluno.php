<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\models\ModalidadeDataHora;

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
 *
 * @property CANDIDATO $cAND
 */
class Aluno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ALUNO';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAND_ID', 'ALU_ID'], 'required'],
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
            [['CAND_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CANDIDATO::className(), 'targetAttribute' => ['CAND_ID' => 'CAND_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ALU_ESTADO_CIVIL' => 'Alu  Estado  Civil',
            'ALU_CPF' => 'Alu  Cpf',
            'ALU_LOGRADOURO' => 'Alu  Logradouro',
            'ALU_COMPLEMENTO_END' => 'Alu  Complemento  End',
            'ALU_CEP' => 'Alu  Cep',
            'ALU_BAIRRO' => 'Alu  Bairro',
            'CAND_ID' => 'Cand  ID',
            'ALU_NOME_EMERGENCIA' => 'Alu  Nome  Emergencia',
            'ALU_TEL_EMERGENCIA' => 'Alu  Tel  Emergencia',
            'ALU_NOME_RESPONSAVEL' => 'Alu  Nome  Responsavel',
            'ALU_TEM_COMORBIDADE' => 'Alu  Tem  Comorbidade',
            'ALU_COMORBIDADE_DESC' => 'Alu  Comorbidade  Desc',
            'ALU_TEM_MEDICACAO' => 'Alu  Tem  Medicacao',
            'ALU_MEDICACAO_DESC' => 'Alu  Medicacao  Desc',
            'ALU_OBSERVACOES' => 'Alu  Observacoes',
            'ALU_ID' => 'Alu  ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCAND()
    {
        return $this->hasOne(CANDIDATO::className(), ['CAND_ID' => 'CAND_ID']);
    }
}
