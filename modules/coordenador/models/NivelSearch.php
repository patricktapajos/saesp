<?php

namespace app\modules\coordenador\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\coordenador\models\Nivel;

/**
 * NivelSearch represents the model behind the search form of `app\modules\coordenador\models\Nivel`.
 */
class NivelSearch extends Nivel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NIV_ID'], 'number'],
            [['NIV_DESCRICAO'], 'safe'],
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
        $query = Nivel::find();

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
            'NIV_ID' => $this->NIV_ID,
        ]);

        $query->andFilterWhere(['like', 'NIV_DESCRICAO', $this->NIV_DESCRICAO]);

        return $dataProvider;
    }
}
