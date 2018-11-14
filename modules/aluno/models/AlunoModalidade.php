<?php

namespace app\modules\aluno\models;

use Yii;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\aluno\models\Aluno;


/**
 * This is the model class for table "ALUNO_MODALIDADE".
 *
 * @property string $AMO_ID
 * @property string $ALU_ID
 * @property string $AMO_STATUS
 * @property string $MDT_ID
 */
class AlunoModalidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ALUNO_MODALIDADE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AMO_ID'], 'required'],
            [['AMO_ID', 'ALU_ID', 'MDT_ID'], 'number'],
            [['AMO_STATUS'], 'string', 'max' => 30],
            [['AMO_ID'], 'unique'],
            //[['ALU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Aluno::className(), 'targetAttribute' => ['ALU_ID' => 'ALU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AMO_ID' => 'Amo  ID',
            'ALU_ID' => 'Alu  ID',
            'AMO_STATUS' => 'Amo  Status',
            'MDT_ID' => 'Mdt  ID',
        ];
    }

    public function getModalidadeDataHora(){
        return $this->hasMany(ModalidadeDataHora::className(), ['MDT_ID'=>'MDT_ID']);
    }
}
