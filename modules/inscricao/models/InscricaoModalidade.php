<?php

namespace app\modules\inscricao\models;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\coordenador\models\Modalidade;

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
            'MDT_ID' => 'Modalidade Data Hora',
            'INS_ID' => 'Inscrição',
        ];
    }

    public function getModalidadeDataHora(){
        return $this->hasMany(ModalidadeDataHora::className(), ['MDT_ID'=>'MDT_ID']);
    }


    public function getDiasSemana(){

        $descricao = [];
        foreach ($this->getModalidadeDataHora()->all() as $id => $mdatahora) {
            
            $dias = [];
            $mdiasemana = $mdatahora->getModalidadeDiaSemana()->all();

            foreach ($mdiasemana as $key => $dia) {
                $dias[] = $dia->MDS_DESCRICAO;
            }
            
            $descricao[] =  implode(',',$dias) . ' / ' . $mdatahora->MDT_HORARIO_INICIO. ' - '. $mdatahora->MDT_HORARIO_FIM;
        }
        return implode(',',$descricao);
    }
}