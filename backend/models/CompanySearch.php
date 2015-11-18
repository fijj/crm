<?php
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;


class CompanySearch extends Company
{
    public function rules(){
        return [
            [['shortName', 'companyParam1', 'city', 'managerId'], 'safe']
        ];
    }

    public function searchModel($params)
    {
        //заменить на RBAC в будущем
        if(Yii::$app->user->identity->access > 50){
            $query = Company::find()->joinWith('managers');
        }else{
            $query = Company::find()->where(['managerId' => Yii::$app->user->identity->managerId])->joinWith('managers');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $dataProvider->sort->attributes['managerId'] = [
            'asc' => ['managers.fullName' => SORT_ASC],
            'desc' => ['managers.fullName' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'shortName', $this->shortName])
            ->andFilterWhere(['like', 'companyParam1', $this->companyParam1])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'managers.fullName', $this->managerId]);
        return $dataProvider;
    }
}
