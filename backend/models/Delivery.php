<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;


class Delivery extends ActiveRecord
{
    public $statusLabel = [
        '0' => 'ожидает оплаты',
        '1' => 'отгрузка с зав.',
        '2' => 'в пути',
        '3' => 'прибыл',
    ];

    public function rules(){
        return [
            [['name'], 'required'],
            ['cost', 'double'],
            //[['docFile1', 'docFile2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [[
                'orderId',
                'tracking',
                'status',
                'docNum1',
                'docNum2',
                'docScan1',
                'docScan2',
                'docOrig1',
                'docOrig2',
                'cost'
            ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Транспортная компания',
            'tracking' => 'Номер отслеживания',
            'status' => 'Статус',
            'cost' => 'Стоимость'
        ];
    }

    public function getCompany(){
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }
}
