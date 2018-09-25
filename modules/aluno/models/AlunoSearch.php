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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ALU_ESTADO_CIVIL', 'ALU_CPF', 'ALU_LOGRADOURO', 'ALU_COMPLEMENTO_END', 'ALU_CEP', 'ALU_BAIRRO', 'ALU_NOME_EMERGENCIA', 'ALU_TEL_EMERGENCIA', 'ALU_NOME_RESPONSAVEL', 'ALU_TEM_COMORBIDADE', 'ALU_COMORBIDADE_DESC', 'ALU_TEM_MEDICACAO', 'ALU_MEDICACAO_DESC', 'ALU_OBSERVACOES'], 'safe'],
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
        $query = Aluno::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'CAND_ID' => $this->CAND_ID,
            'ALU_ID' => $this->ALU_ID,
        ]);

        $query->andFilterWhere(['like', 'ALU_ESTADO_CIVIL', $this->ALU_ESTADO_CIVIL])
            ->andFilterWhere(['like', 'ALU_CPF', $this->ALU_CPF])
            ->andFilterWhere(['like', 'ALU_LOGRADOURO', $this->ALU_LOGRADOURO])
            ->andFilterWhere(['like', 'ALU_COMPLEMENTO_END', $this->ALU_COMPLEMENTO_END])
            ->andFilterWhere(['like', 'ALU_CEP', $this->ALU_CEP])
            ->andFilterWhere(['like', 'ALU_BAIRRO', $this->ALU_BAIRRO])
            ->andFilterWhere(['like', 'ALU_NOME_EMERGENCIA', $this->ALU_NOME_EMERGENCIA])
            ->andFilterWhere(['like', 'ALU_TEL_EMERGENCIA', $this->ALU_TEL_EMERGENCIA])
            ->andFilterWhere(['like', 'ALU_NOME_RESPONSAVEL', $this->ALU_NOME_RESPONSAVEL])
            ->andFilterWhere(['like', 'ALU_TEM_COMORBIDADE', $this->ALU_TEM_COMORBIDADE])
            ->andFilterWhere(['like', 'ALU_COMORBIDADE_DESC', $this->ALU_COMORBIDADE_DESC])
            ->andFilterWhere(['like', 'ALU_TEM_MEDICACAO', $this->ALU_TEM_MEDICACAO])
            ->andFilterWhere(['like', 'ALU_MEDICACAO_DESC', $this->ALU_MEDICACAO_DESC])
            ->andFilterWhere(['like', 'ALU_OBSERVACOES', $this->ALU_OBSERVACOES]);

        return $dataProvider;
    }
}
