<?php
namespace backend\controllers\helper;

use DatePeriod;
use DateTime;
use DateInterval;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\helper\notebook\Notebook;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class CallsController extends Controller
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
        if(Yii::$app->user->identity->access < 100){
            $today = Notebook::find()
                ->where('callBack = CURDATE()')
                ->andWhere(['managerId' => Yii::$app->user->identity->managerId])
                ->all();

            $tomorrow = Notebook::find()
                ->where('callBack = CURDATE()+1')
                ->andWhere(['managerId' => Yii::$app->user->identity->managerId])
                ->all();

            $week = Notebook::find()
                ->where('`callBack` BETWEEN  CURDATE() AND CURDATE()+7')
                ->andWhere(['managerId' => Yii::$app->user->identity->managerId])
                ->orderBy('callBack')
                ->all();

            $missed = Notebook::find()
                ->where('callBack < CURDATE()')
                ->andWhere(['managerId' => Yii::$app->user->identity->managerId])
                ->orderBy('callBack')
                ->all();
        }else{
            $today = Notebook::find()
                ->where('callBack = CURDATE()')
                ->all();

            $tomorrow = Notebook::find()
                ->where('callBack = CURDATE()+1')
                ->all();

            $week = Notebook::find()
                ->where('`callBack` BETWEEN  CURDATE() AND CURDATE()+7')
                ->orderBy('callBack')
                ->all();

            $missed = Notebook::find()
                ->where('callBack < CURDATE()')
                ->orderBy('callBack')
                ->all();
        }

        $notebook = new Notebook();
        return $this->render('index', [
            'today' => $today,
            'tomorrow' => $tomorrow,
            'week' => $week,
            'missed' => $missed,
        ]);
    }
}
