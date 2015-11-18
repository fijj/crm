<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class OrdersSearch extends Orders
{

    public function rules(){
        return [
            [['orderNum', 'expire', 'companyId', 'date', 'total', 'managerId', 'status', 'dateOfSale'], 'safe'],
        ];
    }

    public function searchModel($params)
    {
        //заменить на RBAC в будущем
        if(Yii::$app->user->identity->access > 50){
            $query = Orders::find()->joinWith('managers')->joinWith('company');
        }else{
            $query = Orders::find()->where(['managerId' => Yii::$app->user->identity->managerId])->joinWith('managers')->joinWith('company');
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

        $dataProvider->sort->attributes['companyId'] = [
            'asc' => ['company.shortName' => SORT_ASC],
            'desc' => ['company.shortName' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'orderNum', $this->orderNum])
            ->andFilterWhere(['like', 'expire', $this->expire])
            ->andFilterWhere(['like', 'company.shortName', $this->companyId])
            ->andFilterWhere(['like', 'managers.fullName', $this->managerId])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'dateOfSale', $this->dateOfSale]);
        return $dataProvider;
    }
}

