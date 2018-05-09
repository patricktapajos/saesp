<?php

namespace app\modules\inscricao\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\inscricao\models\Candidato;

/**
 * CandidatoSearch represents the model behind the search form about `app\modules\inscricao\models\Candidato`.
 */
class CandidatoSearch extends Candidato
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CAND_ESTADO_CIVIL', 'CAND_CPF', 'CAND_LOGRADOURO', 'CAND_COMPLEMENTO_END', 'CAND_CEP', 'CAND_BAIRRO', 'CAND_NOME_EMERGENCIA', 'CAND_TEL_EMERGENCIA', 'CAND_NOME_RESPONSAVEL', 'CAND_TEM_COMORBIDADE', 'CAND_COMORBIDADE_DESC', 'CAND_TEM_MEDICACAO', 'CAND_MEDICACAO_DESC', 'CAND_OBSERVACOES'], 'safe'],
            [['CAND_ID'], 'number'],
            [['USU_ID'], 'integer'],
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
        $query = Candidato::find();

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
            'USU_ID' => $this->USU_ID,
        ]);

        $query->andFilterWhere(['like', 'CAND_ESTADO_CIVIL', $this->CAND_ESTADO_CIVIL])
            ->andFilterWhere(['like', 'CAND_CPF', $this->CAND_CPF])
            ->andFilterWhere(['like', 'CAND_LOGRADOURO', $this->CAND_LOGRADOURO])
            ->andFilterWhere(['like', 'CAND_COMPLEMENTO_END', $this->CAND_COMPLEMENTO_END])
            ->andFilterWhere(['like', 'CAND_CEP', $this->CAND_CEP])
            ->andFilterWhere(['like', 'CAND_BAIRRO', $this->CAND_BAIRRO])
            ->andFilterWhere(['like', 'CAND_NOME_EMERGENCIA', $this->CAND_NOME_EMERGENCIA])
            ->andFilterWhere(['like', 'CAND_TEL_EMERGENCIA', $this->CAND_TEL_EMERGENCIA])
            ->andFilterWhere(['like', 'CAND_NOME_RESPONSAVEL', $this->CAND_NOME_RESPONSAVEL])
            ->andFilterWhere(['like', 'CAND_TEM_COMORBIDADE', $this->CAND_TEM_COMORBIDADE])
            ->andFilterWhere(['like', 'CAND_COMORBIDADE_DESC', $this->CAND_COMORBIDADE_DESC])
            ->andFilterWhere(['like', 'CAND_TEM_MEDICACAO', $this->CAND_TEM_MEDICACAO])
            ->andFilterWhere(['like', 'CAND_MEDICACAO_DESC', $this->CAND_MEDICACAO_DESC])
            ->andFilterWhere(['like', 'CAND_OBSERVACOES', $this->CAND_OBSERVACOES]);

        return $dataProvider;
    }
}
