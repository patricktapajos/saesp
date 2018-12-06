<?php

namespace app\modules\aluno\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\aluno\models\Aluno;

/**
 * AlunoSearch represents the model behind the search form about `app\modules\aluno\models\Aluno`.
 */
class AlunoSearch extends Aluno
{
    public $USU_NOME;
    public $USU_CPF;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_NOME', 'USU_CPF','ALU_ESTADO_CIVIL', 'ALU_CPF', 'ALU_LOGRADOURO', 'ALU_COMPLEMENTO_END', 'ALU_CEP', 
                'ALU_BAIRRO', 'ALU_NOME_EMERGENCIA', 'ALU_TEL_EMERGENCIA', 'ALU_NOME_RESPONSAVEL', 
                'ALU_TEM_COMORBIDADE', 'ALU_COMORBIDADE_DESC', 'ALU_TEM_MEDICACAO', 'ALU_MEDICACAO_DESC', 'ALU_OBSERVACOES'], 'safe'],
            [['CAND_ID', 'ALU_ID'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Aluno::find()->joinWith(['candidato.usuario']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'USUARIO.USU_NOME', $this->USU_NOME])
            ->andFilterWhere(['like', 'USUARIO.USU_CPF', $this->USU_CPF]);

        return $dataProvider;
    }
}
