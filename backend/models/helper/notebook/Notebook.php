<?php
namespace backend\models\helper\notebook;

use backend\models\settings\Managers;
use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;


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
        4 => 'ждет консультации'
    ];

    public $readyArr = [
        0 => ['color' => '#286090', 'label' => 'холодный'],
        1 => ['color' => '#EC971F', 'label' => 'теплый'],
        2 => ['color' => '#C9302C', 'label' => 'горячий'],
    ];

    public $readyLabelArr = [
        0 => 'холодный',
        1 => 'теплый',
        2 => 'горячий'
    ];

    public function rules(){
        return [
            ['company', 'required', 'on' => 'default'],
            ['email', 'email', 'on' => 'default'],
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

    public function scenarios(){
        return[
            'default' => ['company', 'type', 'city', 'position', 'email', 'firstName', 'secondName', 'thirdName', 'phone', 'comment', 'date', 'callBack', 'ready', 'cameFrom', 'status', 'managerId'],
            'filter' => ['company', 'type', 'city', 'email', 'phone', 'date', 'callBack', 'ready', 'cameFrom', 'status', 'ready', 'managerId']
        ];
    }

    public function searchModel($params)
    {
        //заменить на RBAC в будущем
        $this->scenario = 'filter';
        if(Yii::$app->user->identity->access > 50){
            $query = Notebook::find()->joinWith('managers');
        }else{
            $query = Notebook::find()->where(['managerId' => Yii::$app->user->identity->managerId])->joinWith('managers');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
        ]);

        $dataProvider->sort->attributes['managerId'] = [
            'asc' => ['managers.managerName' => SORT_ASC],
            'desc' => ['managers.managerName' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'notebook.email', $this->email])
            ->andFilterWhere(['like', 'fullName', $this->managerId])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'callBack', $this->callBack])
            ->andFilterWhere(['like', 'ready', $this->ready])
            ->andFilterWhere(['like', 'cameFrom', $this->cameFrom])
            ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
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

    public function getManagers(){
        return $this->hasOne(Managers::className(''), ['id' => 'managerId']);
    }
}
