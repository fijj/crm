<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\settings\Managers;
use backend\models\Counter;

class Orders extends ActiveRecord
{
    public $statusLabel = ['0' => 'ожидает оплату', '1' => 'предоплата', '2' => 'оплачен', '3' => 'закрыт'];
    public $deliveryLabel = ['0' => 'ожидает оплату', '1' => 'предоплата', '2' => 'оплачен'];
    public $whoDeliveryLabel = ['0' => 'ОРОС Медикал', '1' => 'Завод производитель', '2' => 'Покупатель'];
    public $installmentLabel = ['0' => 'Нет', '1' => 'Да'];

    public static function tableName()
    {
        return 'orders';
    }

    public function rules(){
        return [
            [['expire'], 'required'],
            //[['docFile1', 'docFile2', 'docFile3', 'docFile4'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [[
                'orderNum',
                'companyId',
                'date',
                'expire',
                'total',
                'tax',
                'deliveryDate',
                'comment',
                'managerId',
                'managerName',
                'status',
                'installment',
                'docNum1',
                'docNum2',
                'docNum3',
                'docNum4',
                'docScan1',
                'docScan2',
                'docScan3',
                'docScan4',
                'docSend1',
                'docSend2',
                'docSend3',
                'docSend4',
                'docRecive1',
                'docRecive2',
                'docRecive3',
                'docRecive4',
                'delivery',
                'dateOfSale',
                'profit',
                'xray'
            ], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'orderNum' => 'Номер счета',
            'expire' => 'Истекает',
            'date' => 'Дата документа',
            'total' => 'Итого',
            'tax' => 'В том числе НДС',
            'status' => 'Статус',
            'deliveryDate' => 'Срок поставки',
            'comment' => 'Комменарий',
            'delivery' => 'Кто оплачивает доставку',
            'installment' => 'Рассрочка',
            'dateOfSale' => 'Дата реализации',
            'companyId' => 'Компания',
            'profit' => 'Прибыль',
            'xray' => 'Рентген',
            'managerId' => 'Менеджер'
        ];
    }

    public static function orderNumGen(){
        $counter = Counter::findOne(1);
        $num = $counter->num;
        $month = $counter->month;
        $curMonth = date("n");
        if($month != $curMonth){
            $num = 1;
        }else{
            $num += 1;
        }
        $counter->month = $curMonth;
        $counter->num = $num;
        $counter->save();

        $zero = '';
        $len = 3 - strlen($num);
        $i = 0;
        while ($i != $len){
            $zero .= '0';
            $i++;
        }
        $str = $curMonth.'-'.$zero.$num;
        return $str;
    }

    public static function getDeliveryDays($deliveryDate){

        $date1 = new \DateTime(date('Y-m-d'));
        $date2 = new \DateTime($deliveryDate);

        if($date1 > $date2){
            return 0;
        }

        $interval = $date1->diff($date2);

        return $interval->days;
    }

    function getGoods(){
        return $this->hasMany(Goods::className(), ['orderId' => 'id']);
    }

    public function getCompany(){
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }

    public static function paymentsBar($orders, $payments){
        $paymentsBar = [
            'total' => 0,
            'percent' => 0
        ];
        foreach ($payments as $item){
            if ($item->status == 1){
                $paymentsBar['total'] += $item->sum;
            }
        }
        $paymentsBar['total'] = round($paymentsBar['total'],2);
        if($orders->total == 0){
            $paymentsBar['percent'] = 0;
        }else{
            $paymentsBar['percent'] = round($paymentsBar['total']/($orders->total / 100), 2);
        }

        return $paymentsBar;
    }

    public function Profit(){
        $purchasing = Purchasing::find()->where(['orderId' => $this->id])->sum('total');
        $delivery = Delivery::find()->where(['orderId' => $this->id])->sum('cost');
        $profit = $this->total - $purchasing - $delivery;
        return $profit;
    }

    public function getManagers(){
        return $this->hasOne(Managers::className(''), ['id' => 'managerId']);
    }

    public function payments(){
        return Payments::find()->where(['orderId' => $this->id, 'status' => 1])->sum('sum');
    }

    public function goods(){
        return Goods::find()->where(['orderId' => $this->id])->all();
    }

}
