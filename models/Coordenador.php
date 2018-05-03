<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coordenador".
 *
 * @property string $CRD_ID
 * @property integer $USU_ID
 * @property  $
 */
class Coordenador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'COORDENADOR';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CRD_ID' => 'Código',
            'USU_ID' => 'Usuário',
        ];
    }

    public function getUsuario(){
        return $this->hasOne(Usuario::className(), ['USU_ID'=>'USU_ID']);
    }

    public function getCel(){
        return $this->hasOne(Cel::className(), ['CRD_ID'=>'CRD_ID']);
    }
}
