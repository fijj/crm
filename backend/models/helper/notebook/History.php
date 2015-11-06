<?php
namespace backend\models\helper\notebook;

use Yii;
use yii\db\ActiveRecord;


class History extends ActiveRecord
{
    public function rules(){
        return [
            ['text', 'required', 'on' => 'default'],
            [[
                'notebookId',
                'date',
                'time',
            ],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Новая заметка',
        ];
    }

    public function scenarios(){
        return [
            'default' => ['text', 'notebookId', 'date', 'time'],
            'search' => ['text'],
        ];
    }

    function getNotebook(){
        return $this->hasOne(Notebook::className(), ['id' => 'notebookId']);
    }
}
