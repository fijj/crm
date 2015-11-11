<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\Company;
use backend\models\settings\Managers;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\data\Sort;

/**
 * Site controller
 */
class CompanyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'view', 'new', 'edit', 'remove', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $sort = new Sort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'attributes' => [
                'id' => [
                    'label' => 'По порядку',
                ],
                'fullName' => [
                    'label' => 'По компаниям',
                ],
                'managerId' => [
                    'label' => 'По менеджерам',
                ],
                'companyParam1' => [
                    'label' => 'По типу',
                ]
            ],
        ]);

        //заменить на RBAC в будущем

        if(Yii::$app->user->identity->access > 50){
            $model = Company::find()->orderBy($sort->orders)->all();
        }else{
            $model = Company::find()->where(['managerId' => Yii::$app->user->identity->managerId])->orderBy($sort->orders)->all();
        }

        $managers = ArrayHelper::index(Managers::find()->asArray()->all(), 'id');
        return $this->render('index',[
            'model' => $model,
            'managers' => $managers,
            'sort' => $sort,
            'type' => [
                '0' => 'частная',
                '1' => 'государственная',
                '2' => 'сервисная служба',
            ],
        ]);
    }

    public function actionView($id)
    {

        $model = Company::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        return $this->render('view',[
            'model' => $model,
            'manager' => Managers::findOne($model->managerId),
        ]);
    }

    public function actionNew()
    {
        $model = new Company();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->managerId = Yii::$app->user->identity->managerId;
            $model->save();
            $model->saveUser($model);
            return $this->redirect(['/company/index']);
        }

        return $this->render('form',[
            'model' => $model,
            'managers' => ArrayHelper::map(Managers::find()->all(),'id','fullName'),
            'action' => 'create',
            'title' => 'Создать'
        ]);
    }

    public function actionEdit($id)
    {
        $model = Company::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $model->scenario = 'edit';
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            $model->updateUser($model, $id);
            Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['/company/view','id' => $id]);
        }

        return $this->render('form',[
            'model' => $model,
            'managers' => ArrayHelper::map(Managers::find()->all(),'id','fullName'),
            'action' => 'update',
            'title' => 'Редактировать',
            'id' => $id,
        ]);
    }

    //POST ACTION//
    ///////////////
    public function actionRemove($id)
    {
        $model = Company::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $model->delete();
        $model->deleteUser($id);
        return $this->redirect(['/company/index']);
    }
}
