<?php
namespace backend\models\settings;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

class Managers extends ActiveRecord
{
    public $rulesArr= [
        10 => 'Менеджер',
        100 => 'Администратор'
    ];
    public function rules(){
        return [
            [['firstName'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот email уже существует'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['managerPhoto'], 'file'],
            [['managerPhone', 'access', 'secondName', 'thirdName', 'fullName'], 'safe'],
        ];
    }

    public function attributeLabels(){
        return [
            'firstName' => 'Фамилия',
            'secondName' => 'Имя',
            'thirdName' => 'Отчество',
            'fullName' => 'Полное имя',
            'managerPhone' => 'Телефон',
            'email' => 'Почта ',
            'managerPhoto' => 'Фотография',
            'password' => 'Пароль',
            'access' => 'Роль'
        ];
    }

    public function scenarios(){
            return [
                'new' => ['firstName', 'secondName', 'thirdName', 'fullName', 'email', 'password', 'managerPhone', 'managerPhoto', 'access'],
                'edit' => ['firstName', 'secondName', 'thirdName', 'fullName', 'managerPhone', 'access'],
                'removePhoto' => ['managerPhoto'],
                'access' => 'Роль'
            ];
    }

    public function saveUser($model){
        $user = new User;
        $user->username = $model->email;
        $user->managerId = $model->id;
        $user->email = $model->email;
        $user->fullUsername = $model->fullName;
        $user->role = $this->rulesArr[$model->access];
        $user->access = $model->access;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->save();
    }

    public function updateUser($model, $id){
        $user = User::findOne(['managerId' => $id]);
        $user->username = $model->email;
        $user->managerId = $model->id;
        $user->email = $model->email;
        $user->fullUsername = $model->fullName;
        $user->role = $this->rulesArr[$model->access];
        $user->access = $model->access;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->save();
    }

    public function deleteUser($id){
        $user = User::findOne(['managerId' => $id]);
        $user->delete();
        if($this->managerPhoto){
            if(file_exists('uploads/managers/'.$this->managerPhoto)){
                unlink('uploads/managers/'.$this->managerPhoto);
            }
        }
    }

    public function deletePhoto(){
        if($this->managerPhoto){
            if(file_exists('uploads/managers/'.$this->managerPhoto)){
                unlink('uploads/managers/'.$this->managerPhoto);
            }
            $this->scenario = 'removePhoto';
            $this->managerPhoto = '';
            $this->save();
        }
    }
}
