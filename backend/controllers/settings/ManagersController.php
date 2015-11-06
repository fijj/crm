<?php
namespace backend\controllers\settings;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\settings\Managers;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class ManagersController extends Controller
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
                        'actions' => ['index', 'new', 'edit', 'remove', 'create', 'update', 'removephoto'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                                return (Yii::$app->user->identity->access > 50)? true : false;
                            }
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
        $model = Managers::find()->all();
        return $this->render('index',[
            'model' => $model,
        ]);
    }
/*
    public function actionView($id)
    {
        $model = Managers::findOne($id);
        return $this->render('view',[
            'model' => $model,
        ]);
    }
*/
    public function actionNew()
    {
        $model = new Managers();
        $model->scenario = 'new';
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $photo = UploadedFile::getInstance($model, 'managerPhoto');
            if ($photo) {
                $name = uniqid() .'.'. $photo->extension;
                $photo->saveAs('uploads/managers/' . $name);
                $model->managerPhoto = $name;
            }
            $model->save();
            $model->saveUser($model);
            return $this->redirect(['/settings/managers/index']);
        }
        return $this->render('form',[
            'model' => $model,
            'action' => 'create',
            'title' => 'Создать'
        ]);
    }

    public function actionEdit($id)
    {
        $model = Managers::findOne($id);
        $model->scenario = 'edit';
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $photo = UploadedFile::getInstance($model, 'managerPhoto');
            if ($photo) {
                $name = uniqid() .'.'. $photo->extension;
                $photo->saveAs('uploads/managers/' . $name);
                $model->managerPhoto = $name;
            }
            $model->save();
            $model->updateUser($model, $id);
            Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['/settings/managers/edit', 'id' => $id]);
        }
        return $this->render('form',[
            'model' => $model,
            'action' => 'update',
            'title' => 'Редактировать',
            'id' => $id,
        ]);
    }

    //POST ACTION//
    ///////////////
    public function actionRemove($id)
    {
        $model = Managers::findOne($id);
        $model->delete();
        $model->deleteUser($id);
        return $this->redirect(['/settings/managers/index']);
    }

    public function actionRemovephoto($id)
    {
        $model = Managers::findOne($id);
        $model->deletePhoto();
        return $this->redirect(['/settings/managers/edit', 'id' => $id]);
    }

    public function actionChangeemail($id)
    {
        $model = Managers::findOne($id);
        $model->deletePhoto();
        return $this->redirect(['/settings/managers/edit', 'id' => $id]);
    }
}
