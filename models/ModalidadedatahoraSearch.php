<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Modalidadedatahora;

/**
 * ModalidadedatahoraSearch represents the model behind the search form of `app\models\Modalidadedatahora`.
 */
class ModalidadedatahoraSearch extends Modalidadedatahora
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MDT_HORARIO_INICIO', 'MDT_HORARIO_FIM'], 'safe'],
            [['MDT_QTDE_VAGAS', 'MDT_ID', 'SMOD_ID', 'PROF_ID'], 'number'],
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
        $query = Modalidadedatahora::find();

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
            'MDT_QTDE_VAGAS' => $this->MDT_QTDE_VAGAS,
            'MDT_ID' => $this->MDT_ID,
            'SMOD_ID' => $this->SMOD_ID,
            'PROF_ID' => $this->PROF_ID,
            'MDT_STATUS' => $this->MDT_STATUS,
        ]);

        $query->andFilterWhere(['like', 'MDT_HORARIO_INICIO', $this->MDT_HORARIO_INICIO])
            ->andFilterWhere(['like', 'MDT_HORARIO_FIM', $this->MDT_HORARIO_FIM]);

        return $dataProvider;
    }
}
