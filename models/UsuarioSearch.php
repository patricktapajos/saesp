<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_ID'], 'integer'],
            [['USU_NOME', 'USU_CPF','USU_SEXO', 'USU_SITUACAO', 'USU_PERMISSAO'], 'safe'],
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
        $query = Usuario::find()->orderBy(['USU_NOME'=>SORT_ASC]);

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
        $query->andFilterWhere(['like', 'USU_NOME', $this->USU_NOME])
            ->andFilterWhere(['like', 'USU_CPF', $this->USU_CPF])
            ->andFilterWhere(['like', 'USU_SEXO', $this->USU_SEXO])
            ->andFilterWhere(['like', 'USU_SITUACAO', $this->USU_SITUACAO])
            ->andFilterWhere(['like', 'USU_PERMISSAO', $this->USU_PERMISSAO]);

        return $dataProvider;
    }
}
