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
        return 'administrador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adm_id', ''], 'required'],
            [['adm_id'], 'number'],
            [['usu_id'], 'integer'],
            [[''], 'string'],
            [[''], 'unique'],
            [['USU_ID'], 'exist', 'skipOnError' => true, 'targetClass' => USUARIO::className(), 'targetAttribute' => ['USU_ID' => 'USU_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adm_id' => 'Adm ID',
            'usu_id' => 'Usu ID',
            '' => '',
        ];
    }
}
