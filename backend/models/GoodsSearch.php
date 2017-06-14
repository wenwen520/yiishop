<?php

namespace common\models\search;

use backend\models\Goods;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GoodsSearch extends Goods
{
    //public $cname;//文章类别名

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid','created_at', 'updated_at'], 'integer'],
            [['id', 'desc','title','cover','content'], 'safe'],
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

    //搜索
    public function search($params)
    {
        $query = Goods::find();
        // $query->joinWith(['cate']);//关联文章类别表
        // $query->joinWith(['author' => function($query) { $query->from(['author' => 'users']); }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        // 从参数的数据中加载过滤条件，并验证
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // 增加过滤条件来调整查询对象
        $query->andFilterWhere([
            // 'cname' => $this->cate.cname,
            'name' => $this->name,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        //$query->andFilterWhere(['like', 'cate.cname', $this->cname]) ;

        return $dataProvider;
    }
}
