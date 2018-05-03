<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administrador".
 *
 * @property string $adm_id
 * @property integer $usu_id
 * @property  $
 */
class Administrador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ADMINISTRADOR';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ADM_ID'], 'number'],
            [['USU_ID'], 'integer'],
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ADM_ID' => 'Adm ID',
            'usu_id' => 'Usu ID',
        ];
    }
}
