<?php

namespace app\models;
use app\models\Usuario;

use Yii;

/**
 * This is the model class for table "ESTAGIARIO".
 *
 * @property string $EST_ID
 * @property int $USU_ID
 */
class Estagiario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ESTAGIARIO';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
          [['USU_ID'], 'required'],
          [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EST_ID' => 'ID',
            'USU_ID' => 'Estagiario',
        ];
    }

    public function getUsuario(){
        return $this->hasOne(Usuario::className(), ['USU_ID'=>'USU_ID']);
    }
}
