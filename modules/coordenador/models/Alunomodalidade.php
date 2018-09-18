<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\models\ModalidadeDataHora;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Aluno;
use app\models\Modalidade;
use app\models\Selecaomodalidade;
/**
 * This is the model class for table "ALUNO_MODALIDADE".
 *
 * @property string $AMO_ID
 * @property string $ALU_ID
 * @property string $SMOD_ID
 * @property string $AMO_STATUS ATIVO, INATIVO, DESISTÊNCIA
 *
 * @property SELECAOMODALIDADE $sMOD
 */
class Alunomodalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ALUNO_MODALIDADE';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ALU_ID'], 'required'],
            [['AMO_ID', 'ALU_ID', 'SMOD_ID'], 'number'],
            [['AMO_STATUS'], 'string', 'max' => 30],
            [['AMO_ID'], 'unique'],
            [['SMOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Selecaomodalidade::className(), 'targetAttribute' => ['SMOD_ID' => 'SMOD_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AMO_ID' => 'Modalidade',
            'ALU_ID' => 'Aluno',
            'SMOD_ID' => 'Modalidade Selecionada',
            'AMO_STATUS' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelecaomodalidade()
    {
        return $this->hasOne(Selecaomodalidade::className(), ['SMOD_ID' => 'SMOD_ID']);
    }
    public function getAluno()
    {
        return $this->hasOne(Aluno::className(), ['ALU_ID' => 'ALU_ID']);
    }
    public function getModalidade()
    {
        return $this->hasOne(Modalidade::className(), ['MOD_ID' => 'MOD_ID']);
    }
}
