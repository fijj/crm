<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use backend\models\settings\Managers;


class Company extends ActiveRecord
{
    public $typeArr = [
        0 => 'частная',
        1 => 'государственная',
        2 => 'сервисная служба'
    ];

    public static function tableName()
    {
        return 'company';
    }

    public function rules(){
        return [
            [['fullName'], 'required'],
            [['companyParam18', 'companyParam24'], 'email'],
            ['companyParam18', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот email уже существует'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [[
                'shortName',
                'companyParam1',
                'companyParam2',
                'companyParam3',
                'companyParam4',
                'companyParam5',
                'companyParam6',
                'companyParam7',
                'companyParam8',
                'companyParam9',
                'companyParam10',
                'companyParam11',
                'companyParam12',
                'companyParam13',
                'companyParam14',
                'companyParam15',
                'companyParam16',
                'companyParam17',
                'companyParam18',
                'companyParam19',
                'companyParam20',
                'companyParam21',
                'companyParam22',
                'companyParam23',
                'companyParam24',
                'managerId'
            ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fullName' => 'Наименование юр. лица ',
            'shortName' => 'Сокращенное наименование ',
            'companyParam1' => 'Тип ',
            'companyParam2' => 'ИНН ',
            'companyParam3' => 'КПП ',
            'companyParam4' => 'ОКПО ',
            'companyParam5' => 'ОГРН ',
            'companyParam6' => 'Юридический адрес ',
            'companyParam7' => 'Почтовый адрес ',
            'companyParam8' => 'Генеральный директор ',
            'companyParam9' => 'Наименование банка ',
            'companyParam10' => 'Расчетный счет компании ',
            'companyParam11' => 'Корреспондентский счет банка ',
            'companyParam12' => 'БИК банка ',
            'companyParam13' => 'Имя ',
            'companyParam14' => 'Фамилия ',
            'companyParam15' => 'Отчество ',
            'companyParam16' => 'Должность ',
            'companyParam17' => 'Телефон ',
            'companyParam18' => 'Почта ',
            'companyParam19' => 'Комментарий ',
            'companyParam20' => 'Имя ',
            'companyParam21' => 'Фамилия ',
            'companyParam22' => 'Отчество ',
            'companyParam23' => 'Телефон ',
            'companyParam24' => 'Почта ',
            'email' => 'Почта для входа',
            'password' => 'Пароль',
            'managerId' => 'Менеджер',
            'city' => 'Город'
        ];
    }
    public function scenarios()
    {
        return[
            'default'=> [
                'fullName',
                'shortName',
                'companyParam1',
                'companyParam2',
                'companyParam3',
                'companyParam4',
                'companyParam5',
                'companyParam6',
                'companyParam7',
                'companyParam8',
                'companyParam9',
                'companyParam10',
                'companyParam11',
                'companyParam12',
                'companyParam13',
                'companyParam14',
                'companyParam15',
                'companyParam16',
                'companyParam17',
                'companyParam18',
                'companyParam19',
                'companyParam20',
                'companyParam21',
                'companyParam22',
                'companyParam23',
                'companyParam24',
                'email',
                'password',
                'managerId',
                'city'
            ],
            'update' => [
                'fullName',
                'shortName',
                'companyParam1',
                'companyParam2',
                'companyParam3',
                'companyParam4',
                'companyParam5',
                'companyParam6',
                'companyParam7',
                'companyParam8',
                'companyParam9',
                'companyParam10',
                'companyParam11',
                'companyParam12',
                'companyParam13',
                'companyParam14',
                'companyParam15',
                'companyParam16',
                'companyParam17',
                'companyParam18',
                'companyParam19',
                'companyParam20',
                'companyParam21',
                'companyParam22',
                'companyParam23',
                'companyParam24',
                'password',
                'managerId',
                'city'
            ]
        ];
    }

    public function saveUser($model){
        $user = new User;
        $user->username = $model->email;
        $user->companyId = $model->id;
        $user->email = $model->email;
        $user->role = 'Пользователь';
        $user->access = 0;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->save();
    }

    public function updateUser($model, $id){
        $user = User::findOne(['companyId' => $id]);
        $user->username = $model->email;
        $user->companyId = $model->id;
        $user->email = $model->email;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->save();
    }
    public function deleteUser($id){
        $user = User::findOne(['companyId' => $id]);
        $user->delete();
    }

    public function getManagers(){
        return $this->hasOne(Managers::className(''), ['id' => 'managerId']);
    }

}
