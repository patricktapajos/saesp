<?php

namespace app\models;
use app\models\Modalidade;

use Yii;

/**
 * This is the model class for table "CATEGORIA".
 *
 * @property int $CAT_ID
 * @property string $CAT_DESCRICAO
 * @property string $CAT_OBS
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CATEGORIA';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAT_DESCRICAO'], 'required'],
            [['CAT_ID'], 'integer'],
            [['CAT_DESCRICAO'], 'string', 'max' => 70],
            [['CAT_OBS'], 'string', 'max' => 50],
            [['CAT_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CAT_ID' => 'Cat  ID',
            'CAT_DESCRICAO' => 'Categoria',
            'CAT_OBS' => 'Obs',
        ];
    }

    public function getModalidade(){
        return $this->hasOne(Modalidade::className(), ['MOD_ID'=>'MOD_ID']);
    }

    public static function listarCategoria(){
      return Categoria::model()->findAll();
    }

    public function getCategoria(){
        return $this->hasOne(Categoria::className(), ['CAT_ID'=>'CAT_ID']);
    }
}
