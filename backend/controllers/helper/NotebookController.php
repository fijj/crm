<?php
namespace backend\controllers\helper;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\helper\notebook\Notebook;
use backend\models\helper\notebook\History;
use backend\models\helper\notebook\SearchForm;
use backend\models\settings\Managers;
use yii\helpers\ArrayHelper;
use yii\data\Sort;
use yii\web\ForbiddenHttpException;
use backend\models\Model;
use yii\web\UploadedFile;
use backend\models\helper\notebook\Kp;

/**
 * Site controller
 */
class NotebookController extends Controller
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
                        'actions' => ['index', 'view', 'new', 'edit', 'remove', 'create', 'update', 'search', 'remove-file'],
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
                'company' => [
                    'label' => 'По компаниям',
                ],
                'managerId' => [
                    'label' => 'По менеджерам',
                ],
                'status' => [
                    'label' => 'По статусу',
                ],
                'type' => [
                    'label' => 'По типу',
                ],
                'cameFrom' => [
                    'label' => 'По типу контакта',
                ],
                'callBack' => [
                    'label' => 'По дате обратного звонка',
                ],
                'ready' => [
                    'label' => 'По готовности',
                ]
            ],
        ]);

        //заменить на RBAC в будущем

        if(Yii::$app->user->identity->access > 50){
            $model = Notebook::find()->orderBy($sort->orders)->all();
        }else{
            $model = Notebook::find()->where(['managerId' => Yii::$app->user->identity->managerId])->orderBy($sort->orders)->all();
        }

        $search = new SearchForm();
        return $this->render('index',[
            'model' => $model,
            'search' => $search,
            'managers' => ArrayHelper::index(Managers::find()->asArray()->all(), 'id'),
            'sort' => $sort
        ]);
    }

    public function actionSearch($text){
        $model = History::find()->where(['LIKE', 'text', $text])->all();
        return $this->render('search',[
            'model' => $model,
            'notebook' => ArrayHelper::index(Notebook::find()->asArray()->all(), 'id'),
            'managers' => ArrayHelper::index(Managers::find()->asArray()->all(), 'id'),
        ]);
    }

    public function actionView($id)
    {
        $model = Notebook::findOne($id);

        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }

        $historyModel = new History();
        $history = History::find()->where(['notebookId' => $id])->orderBy(['date' => SORT_DESC, 'time' => SORT_DESC])->all();
        if($historyModel->load(Yii::$app->request->post()) && $historyModel->validate()){
            $historyModel->notebookId = $id;
            $historyModel->date = date('Y-m-d');
            $historyModel->time = date('H:i:s');
            $historyModel->save();
            return $this->redirect(['/helper/notebook/view','id' => $id]);
        }
        return $this->render('view',[
            'model' => $model,
            'historyModel' => $historyModel,
            'history' => $history,
            'manager' => Managers::findOne($model->managerId),
        ]);
    }

    public function actionNew()
    {
        $model = new Notebook();
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            //Администратор сам привязывает менеджеров Заменить на RBAC
            if(Yii::$app->user->identity->access < 100){
                $model->managerId = Yii::$app->user->identity->managerId;
            }
            $model->date = date('Y-m-d');
            $model->save();

            return $this->redirect(['/helper/notebook/index']);
        }

        return $this->render('form',[
            'model' => $model,
            'action' => 'create',
            'title' => 'Создать',
            'managers' => ArrayHelper::map(Managers::find()->all(),'id','managerName'),
        ]);
    }

    public function actionEdit($id)
    {
        $model = Notebook::findOne($id);
        $kp = new Kp();

        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }

        if($model->load(Yii::$app->request->post()) && $kp->load(Yii::$app->request->post()) && $model->validate() && $kp->validate()){

            $model->save();
            if(UploadedFile::getInstance($kp, 'file')){
                $kp->file = Model::uploadFile('kp/', 'Kp[file]', uniqid(Yii::$app->user->identity->managerId.'-kp-'), $kp->file);
                $kp->name = (!$kp->name) ?  $kp->file : $kp->name;
                $kp->companyId = $model->id;
                $kp->managerId = Yii::$app->user->identity->managerId;
                $kp->date = date("Y-m-d");
                $kp->save();
            }
            Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['/helper/notebook/edit','id' => $id]);
        }

        return $this->render('form',[
            'model' => $model,
            'kp' => $kp,
            'managers' => ArrayHelper::map(Managers::find()->all(),'id','managerName'),
            'action' => 'update',
            'title' => 'Редактировать',
            'id' => $id,
        ]);
    }

    //POST ACTION//
    ///////////////
    public function actionRemove($id)
    {
        $model = Notebook::findOne($id);

        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        foreach ($model->kp as $data){
            if(file_exists('uploads/kp/'.$data->file)){
                unlink('uploads/kp/'.$data->file);
            }
        }
        $model->delete();
        return $this->redirect(['/helper/notebook/index']);
    }

    public function actionRemoveFile($id)
    {
        $model = Kp::findOne($id);

        if(Yii::$app->user->identity->access < 100){
            if($model->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }

        if(file_exists('uploads/kp/'.$model->file)){
            unlink('uploads/kp/'.$model->file);
        }

        $model->delete();
        Yii::$app->getSession()->setFlash('success', 'Файл удален');
        return $this->redirect(['/helper/notebook/edit', 'id' => $model->companyId]);
    }
}
