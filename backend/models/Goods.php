<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;


class Goods extends ActiveRecord
{
    public $taxArr = [
        '0' => '0%',
        '10' => '10%',
        '18' => '18%'
    ];

    public $unitArr = [
        '1' => 'шт.',
        '2' => 'упак.'
    ];

    public function rules(){
        return [
            [['name'], 'required'],
            [['cost', 'discount', 'total', 'taxTotal'], 'double'],
            [['quantity', 'unit'], 'integer'],
            [[
                'orderId',
                'tax',
                'taxInclude',
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'cost' => 'Цена',
            'quantity' => 'Кол-во',
            'unit' => 'Ед. Измерения',
            'discount' => 'Скидка',
            'tax' => 'Налог',
            'taxInclude' => 'Включён в цену',
            'total' => 'Итого',
            'taxTotal' => 'Сумма налога'
        ];
    }
}
