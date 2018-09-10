<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\Categoria;

/**
 * This is the model class for table "MODALIDADE".
 *
 * @property string $MOD_NOME
 * @property string $MOD_DESCRICAO
 * @property string $MOD_ID
 * @property string $CEL_ID
 * @property int $CAT_ID
 *
 * @property CEL $cEL
 * @property CATEGORIA $CATEGORIA
 * @property SELECAOMODALIDADE[] $sELECAOMODALIDADEs
 */
class Modalidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'MODALIDADE';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MOD_NOME'], 'required'],
            [['MOD_ID', 'CEL_ID'], 'number'],
            [['CAT_ID'], 'integer'],
            [['MOD_NOME', 'MOD_DESCRICAO'], 'string', 'max' => 255],
            [['MOD_ID'], 'unique'],
            //[['CEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CEL::className(), 'targetAttribute' => ['CEL_ID' => 'CEL_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MOD_NOME' => 'Modalidade',
            'MOD_DESCRICAO' => 'Descrição Modalidade',
            'MOD_ID' => 'ID',
            'CAT_ID' => 'Categoria',
            //'CEL_ID' => 'Cel',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['CAT_ID' => 'CAT_ID']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSELECAOMODALIDADEs()
    {
        return $this->hasMany(SELECAOMODALIDADE::className(), ['MOD_ID' => 'MOD_ID']);
    }

    public function listarCategoria(){
        return ArrayHelper::map(Coordenador::find()->with('usuario')->joinWith('cel', true, 'LEFT OUTER JOIN')->andWhere('"CEL".CRD_ID is null')->all(), 'CRD_ID','usuario.USU_NOME');
    }

}
