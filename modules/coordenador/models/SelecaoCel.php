<?php

namespace app\modules\coordenador\models;
use app\models\Selecao;
use Yii;

/**
 * This is the model class for table "SELECAO_CEL".
 *
 * @property string $SCEL_ID
 * @property string $CEL_ID
 * @property string $SEL_ID
 */
class SelecaoCel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SELECAO_CEL';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SCEL_ID', 'CEL_ID', 'SEL_ID'], 'number'],
            [['SEL_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Selecao::className(), 'targetAttribute' => ['SEL_ID' => 'SEL_ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SCEL_ID' => 'Código',
            'CEL_ID' => 'CEL',
            'SEL_ID' => 'Seleção',
        ];
    }

    public function init(){
        $this->CEL_ID = Yii::$app->user->identity->cel_id;
        return parent::init();
    }
}
