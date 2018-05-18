<?php

namespace app\modules\coordenador\models;
use app\models\Cel;

use Yii;

/**
 * This is the model class for table "MODALIDADE".
 *
 * @property string $MOD_NOME
 * @property string $MOD_DESCRICAO
 * @property string $MOD_ID
 * @property string $CEL_ID
 */
class Modalidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MODALIDADE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MOD_NOME', 'MOD_DESCRICAO'], 'required'],
            [['MOD_NOME', 'MOD_DESCRICAO'], 'string', 'max' => 255],
            [['CEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Cel::className(), 'targetAttribute' => ['CEL_ID' => 'CEL_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MOD_NOME' => 'Nome',
            'MOD_DESCRICAO' => 'Descrição',
            'MOD_ID' => 'Código',
            'CEL_ID' => 'CEL',
        ];
    }

    public function getCel(){
        return $this->hasOne(Cel::className(), ['CEL_ID'=>'CEL_ID']);
    }

      public function getSelecaoModalidades(){
        return $this->hasMany(SelecaoModalidade::className(), ['MOD_ID'=>'MOD_ID']);
    }

    /*public function beforeSave(){
        if($this->isNewRecord){
            $this->CEL_ID = Yii::$app->user->identity->cel_id;    
        }
        return parent::beforeSave();
    }*/
}