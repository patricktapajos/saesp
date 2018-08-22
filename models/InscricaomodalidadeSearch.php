<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inscricaomodalidade;

/**
 * InscricaomodalidadeSearch represents the model behind the search form of `app\models\Inscricaomodalidade`.
 */
class InscricaomodalidadeSearch extends Inscricaomodalidade
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IMO_ID', 'INS_ID', 'MDT_ID'], 'number'],
            [['IMO_STATUS'], 'safe'],
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
        $query = Inscricaomodalidade::find();

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
            'IMO_ID' => $this->IMO_ID,
            'INS_ID' => $this->INS_ID,
            'MDT_ID' => $this->MDT_ID,
        ]);

        $query->andFilterWhere(['like', 'IMO_STATUS', $this->IMO_STATUS]);

        return $dataProvider;
    }
}
