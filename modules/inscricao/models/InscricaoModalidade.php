<?php

namespace app\modules\inscricao\models;
use app\modules\coordenador\models\ModalidadeDataHora;

use Yii;

/**
 * This is the model class for table "INSCRICAO_MODALIDADE".
 *
 * @property string $IMO_ID
 * @property string $INS_ID
 * @property string $MDT_ID
 */
class InscricaoModalidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'INSCRICAO_MODALIDADE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IMO_ID', 'INS_ID', 'MDT_ID'], 'number'],
            /*[['MDT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ModalidadeDataHora::className(), 'targetAttribute' => ['MDT_ID' => 'MDT_ID']],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IMO_ID' => 'Código',
            'INS_ID' => 'Inscrição',
            'MDT_ID' => 'Modalidade',
        ];
    }

    public function getModalidadeDataHora(){
        return $this->hasMany(ModalidadeDataHora::className(), ['MDT_ID'=>'MDT_ID']);
    }
}