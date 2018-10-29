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
    public $SEL_SITUACAO;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SCEL_ID', 'CEL_ID', 'SEL_ID'], 'number'],
            [['SEL_SITUACAO'], 'string'],
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
        $query = SelecaoCel::find()->joinWith(['selecao'])->where(['CEL_ID'=>Yii::$app->user->identity->cel_id]);

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
            'SELECAO.SEL_SITUACAO' => $this->SEL_SITUACAO,
        ]);

        return $dataProvider;
    }
}
