<?php
namespace backend\models\helper\notebook;

use Yii;
use yii\db\ActiveRecord;


class Notebook extends ActiveRecord
{
    public $typeArr = [
        0 => 'частная',
        1 => 'государственная',
        2 => 'сервисная служба',
        3 => 'перекупщики',
    ];

    public $cameFromArr = [
        0 => 'исходящий звонок',
        1 => 'входящий звонок',
        2 => 'письмо',
        3 => 'заявка на сайте',
    ];

    public $statusArr = [
        0 => 'ожидает цену',
        1 => 'ожидает КП',
        2 => 'не хватает средств',
        3 => 'ожидают согласование бюджета',
    ];

    public $readyArr = [
        0 => ['#286090', 'холодный'],
        1 => ['#EC971F', 'теплый'],
        2 => ['#C9302C', 'горячий'],
    ];

    public function rules(){
        return [
            ['company', 'required'],
            ['email', 'email'],
            [[
                'company',
                'type',
                'city',
                'position',
                'firstName',
                'secondName',
                'thirdName',
                'phone',
                'comment',
                'date',
                'callBack',
                'ready',
                'cameFrom',
                'status',
                'managerId'
            ],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'company' => 'Название компании',
            'city' => 'Город',
            'type' => 'Тип',
            'position' => 'Должность контактного лица',
            'firstName' => 'Фамилия',
            'secondName' => 'Имя',
            'thirdName' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'comment' => 'Комментарий',
            'managerId' => 'Менеджер',
            'date' => 'Дата добавления',
            'callBack' => 'Перезвонить',
            'ready' => 'Готовность клиента',
            'cameFrom' => 'Тип контакта',
            'status' => 'Статус',
        ];
    }

    public function getKp(){
        return $this->hasMany(Kp::className(''), ['companyId' => 'id']);
    }
}
