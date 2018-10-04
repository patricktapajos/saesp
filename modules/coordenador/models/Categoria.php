<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\models\Modalidade;
use yii\helpers\ArrayHelper;
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
            [['CAT_ID'], 'unique', 'message'=>'Categoria com esta descrição já cadastrada'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CAT_ID' => 'Código',
            'CAT_DESCRICAO' => 'Descrição',
            'CAT_OBS' => 'Observação',
        ];
    }

    public function getModalidade(){
        return $this->hasOne(Modalidade::className(), ['MOD_ID'=>'MOD_ID']);
    }

    public static function listarCategoria(){
      return Categoria::model()->orderBy(['CAT_DESCRICAO'=>SORT_ASC])->findAll();
    }

    public function getCategoria(){
        return $this->hasOne(Categoria::className(), ['CAT_ID'=>'CAT_ID']);
    }

    public static function listar(){
        return ArrayHelper::map(self::find()->orderBy(['CAT_DESCRICAO'=>SORT_ASC])->all(), 'CAT_ID','CAT_DESCRICAO');
    }
}
