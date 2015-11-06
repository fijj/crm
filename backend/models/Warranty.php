<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;


class Warranty extends ActiveRecord
{
    public function rules(){
        return [
            [['name', 'date'], 'required'],
            [[
                'companyId',
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Номенклатура',
            'date' => 'Срок гарантии',
        ];
    }

    public function getCompany(){
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }
}
