<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inscricao;

/**
 * InscricaoSearch represents the model behind the search form of `app\models\Inscricao`.
 */
class InscricaoSearch extends Inscricao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAND_ID', 'INS_ID', 'SEL_ID'], 'number'],
            [['INS_PCD', 'INS_SITUACAO', 'INS_DT_CADASTRO', 'INS_NUM_INSCRICAO'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Inscricao::find();

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
            'INS_ID' => $this->INS_ID,
            'SEL_ID' => $this->SEL_ID,
        ]);

        $query->andFilterWhere(['like', 'INS_PCD', $this->INS_PCD])
            ->andFilterWhere(['like', 'INS_SITUACAO', $this->INS_SITUACAO])
            ->andFilterWhere(['like', 'INS_DT_CADASTRO', $this->INS_DT_CADASTRO])
            ->andFilterWhere(['like', 'INS_NUM_INSCRICAO', $this->INS_NUM_INSCRICAO]);

        return $dataProvider;
    }
}
