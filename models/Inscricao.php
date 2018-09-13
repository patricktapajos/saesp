<?php

namespace app\models;

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
 * @property string $INS_NUM_INSCRICAO
 *
 * @property SELECAO $sEL
 * @property INSCRICAODOCUMENTO[] $iNSCRICAODOCUMENTOs
 * @property INSCRICAOMODALIDADE[] $iNSCRICAOMODALIDADEs
 */
class Inscricao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'INSCRICAO';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAND_ID', 'INS_ID'], 'required'],
            [['CAND_ID', 'INS_ID', 'SEL_ID'], 'number'],
            [['INS_PCD'], 'string', 'max' => 3],
            [['INS_SITUACAO'], 'string', 'max' => 20],
            [['INS_DT_CADASTRO'], 'string', 'max' => 7],
            [['INS_NUM_INSCRICAO'], 'string', 'max' => 10],
            [['INS_ID'], 'unique'],
            [['SEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SELECAO::className(), 'targetAttribute' => ['SEL_ID' => 'SEL_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CAND_ID' => 'Cand  ID',
            'INS_ID' => 'Ins  ID',
            'INS_PCD' => 'Ins  Pcd',
            'INS_SITUACAO' => 'Ins  Situacao',
            'INS_DT_CADASTRO' => 'Ins  Dt  Cadastro',
            'SEL_ID' => 'Sel  ID',
            'INS_NUM_INSCRICAO' => 'Ins  Num  Inscricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSEL()
    {
        return $this->hasOne(SELECAO::className(), ['SEL_ID' => 'SEL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getINSCRICAODOCUMENTOs()
    {
        return $this->hasMany(INSCRICAODOCUMENTO::className(), ['INS_ID' => 'INS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getINSCRICAOMODALIDADEs()
    {
        return $this->hasMany(INSCRICAOMODALIDADE::className(), ['INS_ID' => 'INS_ID']);
    }

    public function getCANDIDATO()
    {
        return $this->hasOne(CANDIDATO::className(), ['CAND_ID' => 'CAND_ID']);
    }
}
