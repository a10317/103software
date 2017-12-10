<?php

namespace app\controllers;

use Yii;
use app\models\TabelleDbversion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TabelleDbversionController implements the CRUD actions for TabelleDbversion model.
 */
class TabelleDbversionController extends Controller {

    public $success;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TabelleDbversion models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\models\TabelleDbversionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single TabelleDbversion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $providerTabelleDbversionHasTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleDbversionHasTabelleSws,
        ]);
        $providerTabelleSwDb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwDbs,
        ]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'providerTabelleDbversionHasTabelleSw' => $providerTabelleDbversionHasTabelleSw,
                    'providerTabelleSwDb' => $providerTabelleSwDb,
        ]);
    }

    /**
     * Creates a new TabelleDbversion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabelleDbversion();

        if ($model->loadAll(Yii::$app->request->post())) {
            if ($model->saveAll()) {
//                $this->success = 2; // 2->insert erfolgreich
                
//                $model = $this->findModel($model->id);
//                $model->setIsNewRecord(false);
             
                return $this->redirect(['update','id'=>$model->id,'mySuccess' => 2]);
//                return $this->render('update', [
//                            'model' => $model,
//                ]);
//                 $this->redirect(\Yii::$app->urlManager->createUrl("test/show"));
            } else {
                $this->success = -1; // -1->insert Fehler
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabelleDbversion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $mySuccess = 0) {
        $model = $this->findModel($id);
//        if (\kartik\helpers\Enum::isEmpty($model->lock) )
//        {
//            $model->lock = 1;
//        }
        if ($mySuccess != 0)
            $this->success = $mySuccess;
        if ($model->loadAll(Yii::$app->request->post())) {
           
            if ($model->saveAll($model->getRelationData())) {
                $this->success = 1; // 1->update erfolgreich
            } else {
                $this->success = -1; // -1->update Fehler
            }
            return $this->render('update', [
                        'model' => $model,
            ]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TabelleDbversion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 
     * untuk export pdf pada saat actionView
     *  
     * @param type $id
     * @return type
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerTabelleDbversionHasTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleDbversionHasTabelleSws,
        ]);
        $providerTabelleSwDb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwDbs,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerTabelleDbversionHasTabelleSw' => $providerTabelleDbversionHasTabelleSw,
            'providerTabelleSwDb' => $providerTabelleSwDb,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    /**
     * Finds the TabelleDbversion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabelleDbversion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabelleDbversion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleDbversionHasTabelleSw
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleDbversionHasTabelleSw() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleDbversionHasTabelleSw');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleDbversionHasTabelleSw', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwDb
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwDb() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwDb');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwDb', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
