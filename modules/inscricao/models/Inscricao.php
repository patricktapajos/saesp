<?php

namespace app\modules\inscricao\models;
use app\models\SituacaoInscricaoEnum;
use app\modules\inscricao\models\InscricaoDocumento;
use app\modules\inscricao\models\Candidato;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\aluno\models\Aluno;
use app\modules\aluno\models\AlunoSituacaoEnum;
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
    const CENARIO_PARECER = 'parecer';
    public $modalidades;

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
            [['INS_SITUACAO', 'modalidades'], 'required', 'on'=>self::CENARIO_PARECER],
            ['INS_OBSERVACAO', 'required', 'when' => function($model) {
                return $model->INS_SITUACAO == SituacaoInscricaoEnum::INDEFERIDA;
            },'whenClient' => "observacao"],
            [['INS_PCD'], 'string', 'max' => 3],
            [['INS_SITUACAO'], 'string', 'max' => 20],
            //[['INS_DT_CADASTRO'], 'string', 'max' => 7],
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
            'INS_NUM_INSCRICAO' => 'Nº de Inscrição',
            'ins_parecer' => 'Emissão de Parecer',
            'INS_OBSERVACAO' => 'Observação'
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

        if($this->scenario == Inscricao::CENARIO_PARECER && $this->ins_parecer == SituacaoInscricaoEnum::DEFERIDA){
            $this->inserirAluno();
        }
    }


    public function inserirAluno(){
        $aluno = new Aluno;
        $aluno->CAND_ID              = $this->candidato->CAND_ID;
        $aluno->INS_ID               = $this->INS_ID;
        /*$aluno->ALU_CPF              = $this->candidato->CAND_CPF;
        $aluno->ALU_ESTADO_CIVIL     = $this->candidato->CAND_ESTADO_CIVIL;
        $aluno->ALU_LOGRADOURO       = $this->candidato->CAND_LOGRADOURO;
        $aluno->ALU_COMPLEMENTO_END  = $this->candidato->CAND_COMPLEMENTO_END;
        $aluno->ALU_CEP              = $this->candidato->CAND_CEP;
        $aluno->ALU_BAIRRO           = $this->candidato->CAND_BAIRRO;
        $aluno->ALU_NOME_EMERGENCIA  = $this->candidato->CAND_NOME_EMERGENCIA;
        $aluno->ALU_TEL_EMERGENCIA   = $this->candidato->CAND_TEL_EMERGENCIA;
        $aluno->ALU_NOME_RESPONSAVEL = $this->candidato->CAND_NOME_RESPONSAVEL;
        $aluno->ALU_TEM_COMORBIDADE  = $this->candidato->CAND_TEM_COMORBIDADE;
        $aluno->ALU_COMORBIDADE_DESC = $this->candidato->CAND_COMORBIDADE_DESC;
        $aluno->ALU_TEM_MEDICACAO    = $this->candidato->CAND_TEM_MEDICACAO;
        $aluno->ALU_MEDICACAO_DESC   = $this->candidato->CAND_MEDICACAO_DESC;
        $aluno->ALU_OBSERVACOES      = $this->candidato->CAND_OBSERVACOES;*/
        $aluno->save(false);

        foreach(explode(',',$this->modalidades) as $modalidade){
            $im = new AlunoModalidade;
            $im->MDH_ID = $modalidade;
            $im->ALU_ID = $aluno->ALU_ID;
            $im->AMO_STATUS = AlunoSituacaoEnum::ATIVO;
            $im->save(false);
        }
    }

    public function getInscricaodocumento(){
        return $this->hasOne(InscricaoDocumento::className(), ['INS_ID'=>'INS_ID']);
    }

    public function getInscricaomodalidade(){
        return $this->hasMany(InscricaoModalidade::className(), ['INS_ID'=>'INS_ID']);
    }

    public function getCandidato(){
        return $this->hasOne(Candidato::className(), ['CAND_ID'=>'CAND_ID']);
    }

    public function getAluno(){
        return $this->hasOne(Aluno::className(), ['INS_ID'=>'INS_ID']);
    }

    public function getSituacaoText(){
        return SituacaoInscricaoEnum::listar()[$this->INS_SITUACAO];
    }

    public function isDeferido(){
        return $this->INS_SITUACAO == SituacaoInscricaoEnum::DEFERIDA;
    }

    public function isAguardando(){
        return $this->INS_SITUACAO == SituacaoInscricaoEnum::AGUARDE;
    }

}
