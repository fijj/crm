<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;


class Payments extends ActiveRecord
{
    public function rules(){
        return [
            [['date', 'sum'], 'required'],
            ['sum', 'double'],
            [[
                'status',
                'orderId',
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Дата',
            'sum' => 'Сумма',
            'status' => 'Статус',
        ];
    }

    public function getCompany(){
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }
}
