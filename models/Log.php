<?php

namespace app\models;
use Yii;
use app\components\Utils;

/**
 * This is the model class for table "SAESP_LOG".
 *
 * @property int $LOG_CODIGO
 * @property string $LOG_ACAO
 * @property string $LOG_JUSTIFICATIVA
 * @property string $LOG_DATA
 * @property string $LOG_USUARIO
 * @property string $FK_CODIGO
 * @property string $LOG_DADOS_ANTIGOS
 * @property string $LOG_DADOS_NOVOS
 * @property string $LOG_IP
 * @property string $LOG_MAC
 * @property string $LOG_TABELA
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SAESP_LOG';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LOG_CODIGO', 'LOG_ACAO', 'LOG_DATA', 'LOG_USUARIO', 'LOG_TABELA'], 'required'],
            [['LOG_CODIGO'], 'integer'],
            [['FK_CODIGO'], 'number'],
            [['LOG_ACAO', 'LOG_USUARIO'], 'string', 'max' => 250],
            [['LOG_JUSTIFICATIVA', 'LOG_MAC'], 'string', 'max' => 1000],
            [['LOG_DATA'], 'string', 'max' => 7],
            [['LOG_DADOS_ANTIGOS', 'LOG_DADOS_NOVOS'], 'string', 'max' => 2000],
            [['LOG_IP'], 'string', 'max' => 20],
            [['LOG_TABELA'], 'string', 'max' => 60],
            [['LOG_CODIGO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LOG_CODIGO' => 'Log  Codigo',
            'LOG_ACAO' => 'Log  Acao',
            'LOG_JUSTIFICATIVA' => 'Log  Justificativa',
            'LOG_DATA' => 'Log  Data',
            'LOG_USUARIO' => 'Log  Usuario',
            'FK_CODIGO' => 'Fk  Codigo',
            'LOG_DADOS_ANTIGOS' => 'Log  Dados  Antigos',
            'LOG_DADOS_NOVOS' => 'Log  Dados  Novos',
            'LOG_IP' => 'Log  Ip',
            'LOG_MAC' => 'Log  Mac',
            'LOG_TABELA' => 'Log  Tabela',
        ];
    }

    public function init(){
        $this->LOG_USUARIO = Yii::$app->user->identity->id;	
        $this->LOG_MAC = Utils::getMac();
        $this->LOG_IP = Utils::getIP();
		return parent::init();
	} 
}
