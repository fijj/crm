<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\Company;
use backend\models\CompanySearch;
use backend\models\settings\Managers;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

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
                        'actions' => ['index', 'view', 'new', 'delete', 'create', 'update'],
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
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->searchModel(Yii::$app->request->get());
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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

    public function actionUpdate($id)
    {
        $model = Company::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $model->scenario = 'update';
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            $model->updateUser($model, $id);
            Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['/company/update','id' => $id]);
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
    public function actionDelete($id)
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
