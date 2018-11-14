<?php

namespace app\modules\inscricao\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\inscricao\models\Inscricao;

/**
 * InscricaoSearch represents the model behind the search form of `app\models\Inscricao`.
 */
class InscricaoParecerSearch extends Inscricao
{

    public $USU_NOME;
    public $USU_CPF;
    public $SEL_ID;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SEL_ID','USU_NOME','USU_CPF','INS_NUM_INSCRICAO','INS_SITUACAO'], 'safe'],
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
        /*$query = Inscricao::find()->select('INSCRICAO.INS_ID, USUARIO.USU_NOME, USUARIO.USU_CPF, INSCRICAO.INS_NUM_INSCRICAO, CANDIDATO.CAND_ID')
               ->innerJoin('CANDIDATO', 'INSCRICAO.CAND_ID = CANDIDATO.CAND_ID')
               ->innerJoin('USUARIO', 'USUARIO.USU_ID = CANDIDATO.USU_ID')
               ->innerJoin('INSCRICAO_MODALIDADE', 'INSCRICAO.INS_ID = INSCRICAO_MODALIDADE.INS_ID')
               ->innerJoin('MODALIDADE_DATAHORA', 'INSCRICAO_MODALIDADE.MDT_ID = MODALIDADE_DATAHORA.MDT_ID')
               ->innerJoin('SELECAO_MODALIDADE', 'MODALIDADE_DATAHORA.SMOD_ID = SELECAO_MODALIDADE.SMOD_ID')
               ->innerJoin('MODALIDADE', 'SELECAO_MODALIDADE.MOD_ID = MODALIDADE.MOD_ID')
               ->innerJoin('SELECAO', 'SELECAO_MODALIDADE.SEL_ID = SELECAO.SEL_ID')
               ->groupBy('INSCRICAO.INS_ID, USUARIO.USU_NOME, USUARIO.USU_CPF, INSCRICAO.INS_NUM_INSCRICAO, CANDIDATO.CAND_ID');*/
        
        $query = Inscricao::find()->joinWith([
                    'candidato','candidato.usuario','inscricaomodalidade.modalidadeDataHora.selecaoModalidade.cel'
                ])
                ->select('INSCRICAO.INS_ID, USUARIO.USU_NOME, USUARIO.USU_CPF, INSCRICAO.INS_NUM_INSCRICAO,INSCRICAO.INS_SITUACAO, CANDIDATO.CAND_ID')
               ->groupBy('INSCRICAO.INS_ID, USUARIO.USU_NOME, USUARIO.USU_CPF, INSCRICAO.INS_NUM_INSCRICAO,INSCRICAO.INS_SITUACAO, CANDIDATO.CAND_ID');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'INS_NUM_INSCRICAO', $this->INS_NUM_INSCRICAO])
            ->andFilterWhere(['like', 'USUARIO.USU_NOME', $this->USU_NOME])
            ->andFilterWhere(['like', 'USUARIO.USU_CPF', $this->USU_CPF])
            ->andFilterWhere(['like', 'INS_SITUACAO', $this->INS_SITUACAO])
            ->andFilterWhere(['=','CEL.CEL_ID', Yii::$app->user->identity->cel_id])
            ->andFilterWhere(['=','SELECAO_MODALIDADE.SEL_ID', $this->SEL_ID]);
        ;
        return $dataProvider;
    }
}
