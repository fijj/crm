<?php
namespace backend\controllers\settings;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\settings\Details;
use yii\web\User;

/**
 * Site controller
 */
class DetailsController extends Controller
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
                        'actions' => ['index'],
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
        $model = Details::findOne(1);
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['/settings/details/index']);
        }
        return $this->render('form',[
            'model' => $model,
            'action' => 'update',
        ]);
    }
}
