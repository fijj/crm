<?php
namespace backend\models\settings;

use Yii;
use yii\db\ActiveRecord;


class Details extends ActiveRecord
{
    public function rules(){
        return [
            ['detailsParam17', 'email'],
            [[
                'detailsFullName',
                'detailsShortName',
                'detailsParam1',
                'detailsParam2',
                'detailsParam3',
                'detailsParam4',
                'detailsParam5',
                'detailsParam6',
                'detailsParam7',
                'detailsParam8',
                'detailsParam9',
                'detailsParam10',
                'detailsParam11',
                'detailsParam12',
                'detailsParam13',
                'detailsParam14',
                'detailsParam15',
                'detailsParam16',
                'detailsParam17',
                'detailsParam18',
                'detailsParam19',
            ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'detailsFullName' => 'Наименование юр. лица: ',
            'detailsShortName' => 'Сокращенное наименование: ',
            'detailsParam1' => 'Дата регистрации: ',
            'detailsParam2' => 'ИНН: ',
            'detailsParam3' => 'КПП: ',
            'detailsParam4' => 'ОКПО: ',
            'detailsParam5' => 'ОГРН: ',
            'detailsParam6' => 'ОКАТО: ',
            'detailsParam7' => 'ОКВЭД: ',
            'detailsParam8' => 'Юридический адрес: ',
            'detailsParam9' => 'Фактический адрес: ',
            'detailsParam10' => 'Почтовый адрес: ',
            'detailsParam11' => 'Генеральный директор: ',
            'detailsParam12' => 'Наименование банка: ',
            'detailsParam13' => 'Расчетный счет банка: ',
            'detailsParam14' => 'Корреспондентский счет банка: ',
            'detailsParam15' => 'БИК банка: ',
            'detailsParam16' => 'Телефон: ',
            'detailsParam17' => 'Почта: ',
            'detailsParam18' => 'Главный бухгалтер',
            'detailsParam19' => 'Расчетный счет компании',
        ];
    }
}
