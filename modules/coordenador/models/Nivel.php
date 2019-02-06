<?php

namespace app\modules\coordenador\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "NIVEL".
 *
 * @property string $NIV_ID
 * @property string $NIV_DESCRICAO
 */
class Nivel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'NIVEL';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NIV_ID'], 'number'],
            [['NIV_DESCRICAO'], 'string', 'max' => 255],
            [['NIV_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NIV_ID' => 'Código',
            'NIV_DESCRICAO' => 'Descrição',
        ];
    }

     public static function listar(){
        return ArrayHelper::map(self::find()->orderBy(['NIV_DESCRICAO'=>SORT_ASC])->all(), 'NIV_ID','NIV_DESCRICAO');
    }
}
