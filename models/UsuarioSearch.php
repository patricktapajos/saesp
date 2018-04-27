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
            [['usu_id'], 'integer'],
            [['usu_nome', 'usu_cpf', 'usu_email', 'usu_dt_nasc', 'usu_sexo', 'usu_telefone_1', 'usu_telefone_2', 'usu_senha', 'usu_situacao', 'usu_permissao', ''], 'safe'],
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
        $query = Usuario::find();

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
            'usu_id' => $this->usu_id,
        ]);

        $query->andFilterWhere(['like', 'usu_nome', $this->usu_nome])
            ->andFilterWhere(['like', 'usu_cpf', $this->usu_cpf])
            ->andFilterWhere(['like', 'usu_email', $this->usu_email])
            ->andFilterWhere(['like', 'usu_dt_nasc', $this->usu_dt_nasc])
            ->andFilterWhere(['like', 'usu_sexo', $this->usu_sexo])
            ->andFilterWhere(['like', 'usu_telefone_1', $this->usu_telefone_1])
            ->andFilterWhere(['like', 'usu_telefone_2', $this->usu_telefone_2])
            ->andFilterWhere(['like', 'usu_senha', $this->usu_senha])
            ->andFilterWhere(['like', 'usu_situacao', $this->usu_situacao])
            ->andFilterWhere(['like', 'usu_permissao', $this->usu_permissao]);

        return $dataProvider;
    }
}
