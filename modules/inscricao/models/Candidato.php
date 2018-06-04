<?php

namespace app\modules\inscricao\models;
use app\models\Usuario;
use app\modules\inscricao\models\Inscricao;
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
    public $modalidade;
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
            [['modalidades','CAND_ESTADO_CIVIL','CAND_CEP','CAND_LOGRADOURO','CAND_BAIRRO'], 'required'],
            ['CAND_NOME_RESPONSAVEL', 'required', 'when' => function($model) {
                return $model->CAND_MENOR_IDADE == '1';
            }],
            ['CAND_PCD_DESC', 'required', 'when' => function($model) {
                return $model->CAND_PCD == '1';
            }],
            ['CAND_MEDICACAO_DESC', 'required', 'when' => function($model) {
                return $model->CAND_TEM_MEDICACAO == '1';
            }],
            ['CAND_COMORBIDADE_DESC', 'required', 'when' => function($model) {
                return $model->CAND_TEM_COMORBIDADE == '1';
            }],
            [['CAND_ESTADO_CIVIL'], 'string', 'max' => 15],
            [['CAND_CPF'], 'string', 'max' => 14],
            [['CAND_LOGRADOURO', 'CAND_COMPLEMENTO_END', 'CAND_BAIRRO', 'CAND_NOME_EMERGENCIA', 'CAND_NOME_RESPONSAVEL'], 'string', 'max' => 255],
            [['CAND_CEP'], 'string', 'max' => 10],
            [['CAND_TEL_EMERGENCIA'], 'string', 'max' => 10],
            [['CAND_TEM_COMORBIDADE', 'CAND_TEM_MEDICACAO', 'CAND_PCD', 'CAND_MENOR_IDADE'], 'string', 'max' => 3],
            [['CAND_COMORBIDADE_DESC', 'CAND_MEDICACAO_DESC','CAND_PCD_DESC'], 'string', 'max' => 500],
            [['CAND_OBSERVACOES'], 'string', 'max' => 1500],
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
            'CAND_TEM_COMORBIDADE' => 'Possui alguma comorbidade?',
            'CAND_COMORBIDADE_DESC' => 'Comorbidade(s)',
            'CAND_TEM_MEDICACAO' => 'Ingere algum medicamento?',
            'CAND_MEDICACAO_DESC' => 'Medicamento(s)',
            'CAND_OBSERVACOES' => 'Observações',
            'CAND_PCD' => 'PcD (Pessoa Com Deficiência)',
            'CAND_PCD_DESC' => 'Descrição da Deficiência',
            'CAND_MENOR_IDADE' => 'Candidato Menor de Idade',
        ];
    }

     public function beforeValidate(){
        $this->CAND_CEP = preg_replace('/[^0-9]/', '', $this->CAND_CEP);
        return parent::beforeValidate();
    }

    public function getUsuario(){
        return $this->hasOne(Usuario::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getInscricao(){
        return $this->hasOne(Inscricao::className(), ['CAND_ID'=>'CAND_ID']);
    }
}