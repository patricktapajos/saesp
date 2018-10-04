<?php

namespace app\modules\coordenador\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\coordenador\models\Categoria;

/**
 * CategoriaSearch represents the model behind the search form of `app\models\Categoria`.
 */
class CategoriaSearch extends Categoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAT_ID'], 'integer'],
            [['CAT_DESCRICAO', 'CAT_OBS'], 'safe'],
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
        $query = Categoria::find()->orderBy(['CAT_DESCRICAO' => SORT_ASC]);

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
            'CAT_ID' => $this->CAT_ID,
        ]);

        $query->andFilterWhere(['like', 'CAT_DESCRICAO', $this->CAT_DESCRICAO])
            ->andFilterWhere(['like', 'CAT_OBS', $this->CAT_OBS]);

        return $dataProvider;
    }
}
