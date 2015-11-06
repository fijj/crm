<?php
namespace backend\models\helper\notebook;

use Yii;
use yii\db\ActiveRecord;


class Kp extends ActiveRecord
{

    public function rules(){
        return [
            [[
                'name',
                'companyId',
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Коммерческое предложение',
            'name' => 'Название КП',
        ];
    }
}
