<?php

namespace app\modules\coordenador\models;

use Yii;

/**
 * This is the model class for table "MODALIDADE_DIASEMANA".
 *
 * @property string $MDS_ID
 * @property string $MDS_DESCRICAO
 * @property string $MDT_ID
 */
class ModalidadeDiaSemana extends \yii\db\ActiveRecord
{
    const SCENARIO_VALIDACAO_JSON = 'validacaojson';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MODALIDADE_DIASEMANA';
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios [self::SCENARIO_VALIDACAO_JSON] = [];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MDT_ID'], 'required', 'on'=>'insert'],
            [['MDT_ID'], 'number'],
            [['MDS_ID'], 'string', 'max' => 18],
            [['MDS_DESCRICAO'], 'string', 'max' => 10],
            [['MDT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => MODALIDADEDATAHORA::className(), 'targetAttribute' => ['MDT_ID' => 'MDT_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MDS_ID' => 'Código',
            'MDS_DESCRICAO' => 'Descrição',
            'MDT_ID' => 'Modalidade Data/Hora',
        ];
    }
}
