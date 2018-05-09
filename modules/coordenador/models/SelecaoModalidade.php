<?php

namespace app\modules\coordenador\models;

use Yii;

/**
 * This is the model class for table "SELECAO_MODALIDADE".
 *
 * @property string $SMOD_ID
 * @property string $SEL_ID
 * @property string $MOD_ID
 * @property string $PROF_ID
 */
class SelecaoModalidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO_MODALIDADE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SMOD_ID'], 'required'],
            [['SMOD_ID', 'SEL_ID', 'MOD_ID', 'PROF_ID'], 'number'],
            [['SMOD_ID'], 'unique'],
            [['PROF_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['PROF_ID' => 'PROF_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SMOD_ID' => 'Smod  ID',
            'SEL_ID' => 'Sel  ID',
            'MOD_ID' => 'Mod  ID',
            'PROF_ID' => 'Prof  ID',
        ];
    }
}
