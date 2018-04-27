<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coordenador".
 *
 * @property string $crd_id
 * @property integer $usu_id
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
            [['crd_id', ''], 'required'],
            [['crd_id'], 'number'],
            [['usu_id'], 'integer'],
            [['usu_id'], 'exist', 'skipOnError' => true, 'targetClass' => USUARIO::className(), 'targetAttribute' => ['usu_id' => 'usu_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crd_id' => 'Código',
            'usu_id' => 'Usuário',
        ];
    }
}
