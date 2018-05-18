<?php

namespace app\modules\inscricao\models;
use app\models\Usuario;
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
 * @property integer $USU_ID
 * @property string $CAND_NOME_EMERGENCIA
 * @property string $CAND_TEL_EMERGENCIA
 * @property string $CAND_NOME_RESPONSAVEL
 * @property string $CAND_TEM_COMORBIDADE
 * @property string $CAND_COMORBIDADE_DESC
 * @property string $CAND_TEM_MEDICACAO
 * @property string $CAND_MEDICACAO_DESC
 * @property string $CAND_OBSERVACOES
 */
class Candidato extends \yii\db\ActiveRecord
{
    public $modalidades;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CANDIDATO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modalidades'], 'required'],
            [['CAND_ID'], 'number'],
            [['USU_ID'], 'integer'],
            [['CAND_ESTADO_CIVIL'], 'string', 'max' => 15],
            [['CAND_CPF'], 'string', 'max' => 11],
            [['CAND_LOGRADOURO', 'CAND_COMPLEMENTO_END', 'CAND_BAIRRO', 'CAND_NOME_EMERGENCIA', 'CAND_NOME_RESPONSAVEL'], 'string', 'max' => 255],
            [['CAND_CEP'], 'string', 'max' => 8],
            [['CAND_TEL_EMERGENCIA'], 'string', 'max' => 10],
            [['CAND_TEM_COMORBIDADE', 'CAND_TEM_MEDICACAO'], 'string', 'max' => 3],
            [['CAND_COMORBIDADE_DESC', 'CAND_MEDICACAO_DESC'], 'string', 'max' => 500],
            [['CAND_OBSERVACOES'], 'string', 'max' => 1500],
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CAND_ID' => 'Código',
            'CAND_ESTADO_CIVIL' => 'Estado  Civil',
            'CAND_CPF' => 'CPF',
            'CAND_LOGRADOURO' => 'Logradouro',
            'CAND_COMPLEMENTO_END' => 'Complemento',
            'CAND_CEP' => 'CEP',
            'CAND_BAIRRO' => 'Bairro',
            'USU_ID' => 'Usuário',
            'CAND_NOME_EMERGENCIA' => 'Em caso de emergência, chamar?',
            'CAND_TEL_EMERGENCIA' => 'Número de Emergência',
            'CAND_NOME_RESPONSAVEL' => 'Nome do Responsavel',
            'CAND_TEM_COMORBIDADE' => 'Comorbidade',
            'CAND_COMORBIDADE_DESC' => 'Descrição Comorbidade',
            'CAND_TEM_MEDICACAO' => 'Medicamento',
            'CAND_MEDICACAO_DESC' => 'Descrição Medicamento',
            'CAND_OBSERVACOES' => 'Observações',
        ];
    }
}