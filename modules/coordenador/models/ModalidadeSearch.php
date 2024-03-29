<?php

namespace app\modules\coordenador\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\coordenador\models\Modalidade;

/**
 * ModalidadeSearch represents the model behind the search form about `app\models\Modalidade`.
 */
class ModalidadeSearch extends Modalidade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MOD_NOME', 'MOD_DESCRICAO'], 'safe'],
            [['MOD_ID', 'CEL_ID'], 'number'],
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
        $query = Modalidade::find()->orderBy(['MOD_NOME' => SORT_ASC]);

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
        /*$query->andFilterWhere([
            'CEL_ID' => Yii::$app->user->identity->cel_id,
        ]);*/

        $query->andFilterWhere(['like', 'MOD_NOME', $this->MOD_NOME])
            ->andFilterWhere(['like', 'MOD_DESCRICAO', $this->MOD_DESCRICAO]);

        return $dataProvider;
    }
}
