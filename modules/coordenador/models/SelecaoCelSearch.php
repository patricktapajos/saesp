<?php

namespace app\modules\coordenador\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\coordenador\models\SelecaoCel;

/**
 * SelecaoCelSearch represents the model behind the search form about `app\modules\coordenador\models\SelecaoCel`.
 */
class SelecaoCelSearch extends SelecaoCel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SCEL_ID', 'CEL_ID', 'SEL_ID'], 'number'],
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
        $query = SelecaoCel::find();

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
            'SCEL_ID' => $this->SCEL_ID,
            'CEL_ID' => $this->CEL_ID,
            'SEL_ID' => $this->SEL_ID,
        ]);

        return $dataProvider;
    }
}
