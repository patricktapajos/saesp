<?php

namespace app\models;
use app\models\Usuario;
use Yii;

/**
 * This is the model class for table "PROFESSOR".
 *
 * @property string $PROF_ID
 * @property integer $USU_ID
 */
class Professor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PROFESSOR';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_ID'], 'required'],
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROF_ID' => 'Código',
            'USU_ID' => 'Usuário',
        ];
    }

    public function getUsuario(){
        return $this->hasOne(Usuario::className(), ['USU_ID'=>'USU_ID']);
    }
}