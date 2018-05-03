<?php

namespace app\models;
use app\models\SituacaoSelecaoEnum;
use Yii;

/**
 * This is the model class for table "SELECAO".
 *
 * @property string $SEL_ID
 * @property string $SEL_DT_INICIO
 * @property string $SEL_DT_FIM
 * @property string $SEL_SITUACAO
 */
class Selecao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEL_DESCRICAO'], 'required'],
            [['SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_SITUACAO'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEL_ID' => 'Código',
            'SEL_DESCRICAO'=>'Descrição',
            'SEL_DT_INICIO' => 'Data Início',
            'SEL_DT_FIM' => 'Data Fim',
            'SEL_SITUACAO' => 'Situação',
        ];
    }


    public function getSituacaoText(){
        return SituacaoSelecaoEnum::listar()[$this->SEL_SITUACAO];
    }
}
