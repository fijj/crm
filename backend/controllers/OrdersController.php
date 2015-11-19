<?php
namespace backend\controllers;

use backend\models\Model;
use backend\models\settings\Details;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\Company;
use backend\models\Orders;
use backend\models\Goods;
use yii\helpers\ArrayHelper;
use backend\models\Warranty;
use backend\models\Payments;
use backend\models\Purchasing;
use backend\models\Delivery;
use kartik\mpdf\Pdf;
use yii\web\ForbiddenHttpException;
use yii\data\Sort;
use backend\models\OrdersSearch;
/**
 * Site controller
 */
class OrdersController extends Controller
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
                        'actions' => ['index', 'view', 'new', 'delete', 'create', 'update', 'remove-file', 'generate', 'preview'],
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
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->searchModel(Yii::$app->request->get());
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)

    {
        $orders = Orders::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($orders->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $warranty = Warranty::find()->where(['orderId' => $id])->all();
        $payments = Payments::find()->where(['orderId' => $id])->all();
        $purchasing = Purchasing::find()->where(['orderId' => $id])->all();
        $delivery = Delivery::find()->where(['orderId' => $id])->all();

        if ($orders->load(Yii::$app->request->post())) {

            $warrantyOldIDs = ArrayHelper::map($warranty, 'id', 'id');
            $paymentsOldIDs = ArrayHelper::map($payments, 'id', 'id');
            $purchasingOldIDs = ArrayHelper::map($purchasing, 'id', 'id');
            $deliveryOldIDs = ArrayHelper::map($delivery, 'id', 'id');

            $warranty = Model::createMultiple(Warranty::classname(), $warranty);
            $payments = Model::createMultiple(Payments::classname(), $payments);
            $purchasing = Model::createMultiple(Purchasing::classname(), $purchasing);
            $delivery = Model::createMultiple(Delivery::classname(), $delivery);

            Model::loadMultiple($warranty, Yii::$app->request->post());
            Model::loadMultiple($payments, Yii::$app->request->post());
            Model::loadMultiple($purchasing, Yii::$app->request->post());
            Model::loadMultiple($delivery, Yii::$app->request->post());

            $warrantyDeletedIDs = array_diff($warrantyOldIDs, array_filter(ArrayHelper::map($warranty, 'id', 'id')));
            $paymentsDeletedIDs = array_diff($paymentsOldIDs, array_filter(ArrayHelper::map($payments, 'id', 'id')));
            $purchasingDeletedIDs = array_diff($purchasingOldIDs, array_filter(ArrayHelper::map($purchasing, 'id', 'id')));
            $deliveryDeletedIDs = array_diff($deliveryOldIDs, array_filter(ArrayHelper::map($delivery, 'id', 'id')));

            // validate all models
            $valid = $orders->validate();
            $valid = Model::validateMultiple($warranty) && $valid;
            $valid = Model::validateMultiple($payments) && $valid;
            $valid = Model::validateMultiple($purchasing) && $valid;
            $valid = Model::validateMultiple($delivery) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                        //Загрузка файлов
                        $orders->docFile1 = Model::uploadFile('orders/'.$orders->dir, 'Orders[docFile1]', 'Tovarnaya_nakldanaya', $orders->docFile1);
                        $orders->docFile2 = Model::uploadFile('orders/'.$orders->dir, 'Orders[docFile2]', 'Schet_faktura', $orders->docFile2);
                        $orders->docFile3 = Model::uploadFile('orders/'.$orders->dir, 'Orders[docFile3]', 'Dogovor', $orders->docFile3);
                        $orders->docFile4 = Model::uploadFile('orders/'.$orders->dir, 'Orders[docFile4]', 'Schet', $orders->docFile4);

                    if ($flag = $orders->save(false)) {
                        //Warranty update
                        if (! empty($warrantyDeletedIDs)) {
                            Warranty::deleteAll(['id' => $warrantyDeletedIDs]);
                        }
                        foreach ($warranty as $item) {
                            $item->orderId = $orders->id;
                            $item->companyId = $orders->companyId;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        //Payments update
                        if (! empty($paymentsDeletedIDs)) {
                            Payments::deleteAll(['id' => $paymentsDeletedIDs]);
                        }
                        foreach ($payments as $item) {
                            $item->orderId = $orders->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        //Purchasing update
                        if (! empty($purchasingDeletedIDs)) {
                            $model = Purchasing::findAll($purchasingDeletedIDs);
                            foreach($model as $item){
                                Model::delTree("uploads/orders/{$orders->dir}/$item->dir");
                            }
                            Purchasing::deleteAll(['id' => $purchasingDeletedIDs]);
                        }
                        foreach ($purchasing as $i => $item) {
                            $dir = $item->dir;
                            if(! $dir){
                                $item->dir = $dir = uniqid('purchasing_');
                                if(! file_exists("uploads/orders/{$orders->dir}/$dir")){
                                    mkdir("uploads/orders/{$orders->dir}/$dir");
                                }
                            }
                            $item->docFile1 = Model::uploadFile("orders/$orders->dir/$dir", "Purchasing[$i][docFile1]", 'Tovarnaya_nakldanaya', $item->docFile1);
                            $item->docFile2 = Model::uploadFile("orders/$orders->dir/$dir", "Purchasing[$i][docFile2]", 'Schet_faktura', $item->docFile2);
                            $item->docFile3 = Model::uploadFile("orders/$orders->dir/$dir", "Purchasing[$i][docFile3]", 'Dogovor', $item->docFile3);
                            $item->docFile4 = Model::uploadFile("orders/$orders->dir/$dir", "Purchasing[$i][docFile4]", 'Schet', $item->docFile4);

                            $item->orderId = $orders->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        //Delivery update
                        if (! empty($deliveryDeletedIDs)) {
                            $model = Delivery::findAll($deliveryDeletedIDs);
                            foreach($model as $item){
                                Model::delTree("uploads/orders/{$orders->dir}/$item->dir");
                            }
                            Delivery::deleteAll(['id' => $deliveryDeletedIDs]);
                        }
                        foreach ($delivery as $i => $item) {
                            $dir = $item->dir;
                            if(! $dir){
                                $item->dir = $dir = uniqid('delivery_');
                                if(! file_exists("uploads/orders/{$orders->dir}/$dir")){
                                    mkdir("uploads/orders/{$orders->dir}/$dir");
                                }
                            }
                            $item->docFile1 = Model::uploadFile("orders/$orders->dir/$dir", "Delivery[$i][docFile1]", 'Tovarnaya_nakldanaya', $item->docFile1);
                            $item->docFile2 = Model::uploadFile("orders/$orders->dir/$dir", "Delivery[$i][docFile2]", 'Schet_faktura', $item->docFile2);

                            $item->orderId = $orders->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        //Расчет прибыли
                        $orders->profit = $orders->Profit();
                        $orders->update();
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            if(!$valid){
                Yii::$app->getSession()->setFlash('error', 'Ошибка полей');
            }
        }

        return $this->render('view', [
            'orders' => $orders,
            'warranty' => (empty($warranty)) ? [new Warranty()] : $warranty,
            'payments' => (empty($payments)) ? [new Payments()] : $payments,
            'purchasing' => (empty($purchasing)) ? [new Purchasing()] : $purchasing,
            'delivery' => (empty($delivery)) ? [new Delivery()] : $delivery,
            'deliveryDate' => Orders::getDeliveryDays($orders->deliveryDate),
            'paymentsBar' => Orders::paymentsBar($orders, $payments)
        ]);
    }

    public function actionNew($id)
    {
        $company = Company::findOne($id);

        if(!$company){
            return $this->redirect(['/company/index']);
        }

        if($company->managerId != Yii::$app->user->identity->managerId){
            throw new ForbiddenHttpException('Эта компания не относится к вашей учетной записи, создание счета запрещено');
        }


        $modelOrders = new Orders;
        $modelsGoods = [new Goods];
        if ($modelOrders->load(Yii::$app->request->post())) {

            $modelsGoods = Model::createMultiple(Goods::classname());
            Model::loadMultiple($modelsGoods, Yii::$app->request->post());


            // Валидация всех моделей
            $valid = $modelOrders->validate();
            $valid = Model::validateMultiple($modelsGoods) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    // Заполняем модель

                    $orderNum = Orders::orderNumGen();
                    $dir = $orderNum.'-'.date('Y').'-'.uniqid();

                    $modelOrders->companyId = $id;
                    $modelOrders->date = date('Y-m-d');
                    $modelOrders->orderNum = $orderNum;
                    $modelOrders->dir = $dir;
                    $modelOrders->managerId = Yii::$app->user->identity->managerId;
                    $modelOrders->managerName = Yii::$app->user->identity->fullUsername;

                    if ($flag = $modelOrders->save(false)) {

                        // Создание директории счета
                        mkdir('uploads/orders/'.$dir);

                        foreach ($modelsGoods as $modelGoods) {

                            $modelGoods->orderId = $modelOrders->id;

                            if (! ($flag = $modelGoods->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelOrders->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('form',[
            'modelOrders' => $modelOrders,
            'modelsGoods' => $modelsGoods,
            'company' => Company::findOne($id),
            'action' => 'create',
            'title' => 'Создать счет',
        ]);
    }

    public function actionUpdate($id)
    {
        $modelOrders = Orders::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($modelOrders->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $modelsGoods = Goods::find()->where(['orderId' => $id])->all();

        if ($modelOrders->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsGoods, 'id', 'id');
            $modelsGoods = Model::createMultiple(Goods::classname(), $modelsGoods);
            Model::loadMultiple($modelsGoods, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsGoods, 'id', 'id')));

            // validate all models
            $valid = $modelOrders->validate();
            $valid = Model::validateMultiple($modelsGoods) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelOrders->save(false)) {
                        if (! empty($deletedIDs)) {
                            Goods::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsGoods as $modelGoods) {
                            $modelGoods->orderId = $modelOrders->id;
                            if (! ($flag = $modelGoods->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('form', [
            'modelOrders' => $modelOrders,
            'modelsGoods' => (empty($modelsGoods)) ? [new Goods] : $modelsGoods,
            'company' => $modelOrders->company,
            'action' => 'update',
            'title' => 'Редактировать счет',
        ]);
    }

    public function actionGenerate($id){
        $order = Orders::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($order->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $details = Details::findOne(1);

        if(! $order){
            $this->redirect(['orders/']);
        }

        $content = $this->renderPartial('generate', [
            'order' => $order,
            'details' => $details
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_FILE,
            'content' => $content,
            'filename' =>"uploads/orders/$order->dir/$order->orderNum.pdf",
            'cssFile' => 'css/order.css'
        ]);

        $pdf->render();

        $order->docFile4 = $order->orderNum.'.pdf';
        $order->docNum4 = $order->orderNum;
        $order->save();

        Yii::$app->getSession()->setFlash('success', "Файл счета №$order->orderNum создан");
        return $this->redirect(['/orders/view', 'id' => $id]);
    }

    public function actionPreview($id){
        $order = Orders::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($order->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        $details = Details::findOne(1);

        if(! $order){
            $this->redirect(['orders/']);
        }

        $content = $this->renderPartial('generate', [
            'order' => $order,
            'details' => $details
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => 'css/order.css',

        ]);
        return $pdf->render();
    }

    //POST ACTION//
    ///////////////

    public function actionDelete($id)
    {
        $orders = Orders::findOne($id);
        if(Yii::$app->user->identity->access < 100){
            if($orders->managerId != Yii::$app->user->identity->managerId){
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }
        if ($orders){
            $orders->delete();
            Model::delTree('uploads/orders/'.$orders->dir.'/');
            Yii::$app->getSession()->setFlash('success', "Счет №$orders->orderNum удален");
            return $this->redirect(['/orders/index']);
        }
    }

    public function actionRemoveFile($id, $file, $class){
        $model = "backend\\models\\$class";
        $dir = Orders::findOne($id)->dir;

        if($class == 'Orders'){
            $model = $model::findOne($id);
        }else{
            $model = $model::findOne(['orderId' => $id]);
        }

        $fileName = $model->getAttribute($file);
        $model->setAttribute($file, '');
        $model->save();

        if($class == 'Orders'){
            $dir = "uploads/orders/$dir/";
        }else{
            $dir = "uploads/orders/$dir/$model->dir/";
        }

        if(file_exists($dir.$fileName)){
            unlink($dir.$fileName);
        }

        Yii::$app->getSession()->setFlash('success', "Файл удален");
        return $this->redirect(['/orders/view', 'id' => $id]);
    }
}
