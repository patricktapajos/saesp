<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SELECAO_MODALIDADE".
 *
 * @property string $SMOD_ID
 * @property string $SEL_ID
 * @property string $MOD_ID
 *
 * @property ALUNOMODALIDADE[] $aLUNOMODALIDADEs
 * @property MODALIDADEDATAHORA[] $mODALIDADEDATAHORAs
 * @property MODALIDADE $mOD
 */
class Selecaomodalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SELECAO_MODALIDADE';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SMOD_ID', 'SEL_ID', 'MOD_ID'], 'required'],
            [['SMOD_ID', 'SEL_ID', 'MOD_ID'], 'number'],
            [['SMOD_ID'], 'unique'],
            [['MOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => MODALIDADE::className(), 'targetAttribute' => ['MOD_ID' => 'MOD_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SMOD_ID' => 'Smod  ID',
            'SEL_ID' => 'Sel  ID',
            'MOD_ID' => 'Mod  ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getALUNOMODALIDADEs()
    {
        return $this->hasMany(ALUNOMODALIDADE::className(), ['SMOD_ID' => 'SMOD_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMODALIDADEDATAHORAs()
    {
        return $this->hasMany(MODALIDADEDATAHORA::className(), ['SMOD_ID' => 'SMOD_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMODALIDADE()
    {
        return $this->hasOne(MODALIDADE::className(), ['MOD_ID' => 'MOD_ID']);
    }
}
