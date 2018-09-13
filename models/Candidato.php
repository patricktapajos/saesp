<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CANDIDATO".
 *
 * @property string $CAND_ESTADO_CIVIL
 * @property string $CAND_CPF
 * @property string $CAND_LOGRADOURO
 * @property string $CAND_COMPLEMENTO_END
 * @property string $CAND_CEP
 * @property string $CAND_BAIRRO
 * @property string $CAND_ID
 * @property int $USU_ID
 * @property string $CAND_NOME_EMERGENCIA
 * @property string $CAND_TEL_EMERGENCIA
 * @property string $CAND_NOME_RESPONSAVEL
 * @property string $CAND_TEM_COMORBIDADE
 * @property string $CAND_COMORBIDADE_DESC
 * @property string $CAND_TEM_MEDICACAO
 * @property string $CAND_MEDICACAO_DESC
 * @property string $CAND_OBSERVACOES
 * @property string $CAND_PCD
 * @property string $CAND_PCD_DESC
 * @property string $CAND_MENOR_IDADE
 * @property string $CAND_FOTO
 * @property string $CAND_IDOSO
 *
 * @property ALUNO[] $aLUNOs
 * @property USUARIO $uSU
 */
class Candidato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CANDIDATO';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAND_CEP', 'CAND_ID'], 'required'],
            [['CAND_ID'], 'number'],
            [['USU_ID'], 'integer'],
            [['CAND_ESTADO_CIVIL'], 'string', 'max' => 15],
            [['CAND_CPF'], 'string', 'max' => 11],
            [['CAND_LOGRADOURO', 'CAND_COMPLEMENTO_END', 'CAND_BAIRRO', 'CAND_NOME_EMERGENCIA', 'CAND_NOME_RESPONSAVEL', 'CAND_PCD_DESC'], 'string', 'max' => 255],
            [['CAND_CEP'], 'string', 'max' => 8],
            [['CAND_TEL_EMERGENCIA'], 'string', 'max' => 14],
            [['CAND_TEM_COMORBIDADE', 'CAND_TEM_MEDICACAO', 'CAND_PCD', 'CAND_MENOR_IDADE', 'CAND_IDOSO'], 'string', 'max' => 3],
            [['CAND_COMORBIDADE_DESC', 'CAND_MEDICACAO_DESC'], 'string', 'max' => 500],
            [['CAND_OBSERVACOES'], 'string', 'max' => 1500],
            [['CAND_FOTO'], 'string', 'max' => 120],
            [['CAND_ID'], 'unique'],
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => USUARIO::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CAND_ESTADO_CIVIL' => 'Estado  Civil',
            'CAND_CPF' => 'Cpf',
            'CAND_LOGRADOURO' => 'Logradouro',
            'CAND_COMPLEMENTO_END' => 'Complemento',
            'CAND_CEP' => 'Cep',
            'CAND_BAIRRO' => 'Bairro',
            'CAND_ID' => 'ID',
            'USU_ID' => 'Candidato',
            'CAND_NOME_EMERGENCIA' => 'Nome  Emergencia',
            'CAND_TEL_EMERGENCIA' => 'Tel  Emergencia',
            'CAND_NOME_RESPONSAVEL' => 'Nome  Responsavel',
            'CAND_TEM_COMORBIDADE' => 'Tem  Comorbidade',
            'CAND_COMORBIDADE_DESC' => 'Comorbidade',
            'CAND_TEM_MEDICACAO' => 'Tem  Medicacao',
            'CAND_MEDICACAO_DESC' => 'Medicacao  Desc',
            'CAND_OBSERVACOES' => 'Observacoes',
            'CAND_PCD' => 'Pcd',
            'CAND_PCD_DESC' => 'Pcd  Desc',
            'CAND_MENOR_IDADE' => 'Menor  Idade',
            'CAND_FOTO' => 'Foto',
            'CAND_IDOSO' => 'Idoso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getALUNOs()
    {
        return $this->hasMany(ALUNO::className(), ['CAND_ID' => 'CAND_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSU()
    {
        return $this->hasOne(USUARIO::className(), ['USU_ID' => 'USU_ID']);
    }
}
