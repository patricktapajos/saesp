<?php

namespace app\modules\coordenador\models;
use app\modules\coordenador\models\ModalidadeDataHora;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alunomodalidade;
use app\models\Modalidade;

/**
 * AlunoModalidadeSearch represents the model behind the search form of `app\models\AlunoModalidade`.
 */
class AlunomodalidadeSearch extends AlunoModalidade
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AMO_ID', 'ALU_ID', 'SMOD_ID'], 'number'],
            [['AMO_STATUS'], 'safe'],
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
        $query = AlunoModalidade::find();

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
            'AMO_ID' => $this->AMO_ID,
            'ALU_ID' => $this->ALU_ID,
            'SMOD_ID' => $this->SMOD_ID,
        ]);

        $query->andFilterWhere(['like', 'AMO_STATUS', $this->AMO_STATUS]);

        return $dataProvider;
    }
}
