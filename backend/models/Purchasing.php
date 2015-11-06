<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;


class Purchasing extends ActiveRecord
{
    public $statusLabel = ['0' => 'ожидает оплату', '1' => 'предоплата', '2' => 'оплачен'];

    public function rules(){
        return [
            [['orderNum'], 'required'],
            [['total', 'tax', 'paid'], 'double'],
            //[['docFile1', 'docFile2', 'docFile3', 'docFile4'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [[
                'date',
                'orderId',
                'comment',
                'status',
                'docNum1',
                'docNum2',
                'docNum3',
                'docNum4',
                'docScan1',
                'docScan2',
                'docScan3',
                'docScan4',
                'docOrig1',
                'docOrig2',
                'docOrig3',
                'docOrig4',
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'orderNum' => 'Номер счета',
            'date' => 'Дата документа',
            'total' => 'Итого',
            'tax' => 'В том числе НДС',
            'status' => 'Статус',
            'comment' => 'Комментарий',
            'paid' => 'Оплачено'
        ];
    }

    public function paymentsBar(){
        $paymentsBar = 0;
        if($this->total == 0){
            $paymentsBar = 0;
        }else{
            $paymentsBar = round($this->paid/($this->total / 100), 2);
        }
        return $paymentsBar;
    }

}
