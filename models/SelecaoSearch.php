<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Selecao;

/**
 * SelecaoSearch represents the model behind the search form about `app\models\Selecao`.
 */
class SelecaoSearch extends Selecao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SEL_ID'], 'number'],
            [['SEL_DESCRICAO','SEL_DT_INICIO', 'SEL_DT_FIM', 'SEL_SITUACAO'], 'safe'],
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
        $query = Selecao::find();

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

        $query->andFilterWhere(['like', 'SEL_DT_INICIO', $this->SEL_DT_INICIO])
            ->andFilterWhere(['like', 'SEL_DESCRICAO', $this->SEL_DESCRICAO])
            ->andFilterWhere(['like', 'SEL_DT_FIM', $this->SEL_DT_FIM])
            ->andFilterWhere(['like', 'SEL_SITUACAO', $this->SEL_SITUACAO]);

        return $dataProvider;
    }
}
