<?php

namespace app\controllers;

use Yii;
use app\models\TabelleDlansprechpartner;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TabelleDlansprechpartnerController implements the CRUD actions for TabelleDlansprechpartner model.
 */
class TabelleDlansprechpartnerController extends Controller {

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
     * Lists all TabelleDlansprechpartner models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => TabelleDlansprechpartner::find(),
        ]);
        $searchModel = new \app\models\TabelleDlansprechpartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single TabelleDlansprechpartner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps,
        ]);
        return $this->render('view', [
                    'model' => $model,
                    'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
        ]);
    }

    /**
     * Creates a new TabelleDlansprechpartner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabelleDlansprechpartner();

        if ($model->loadAll(Yii::$app->request->post())) {
            if ($model->saveAll()) {


                return $this->redirect(['update', 'id' => $model->id, 'mySuccess' => 2]);
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
     * Updates an existing TabelleDlansprechpartner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $mySuccess = 0) {
        $model = $this->findModel($id);
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps
        ]);
        if ($mySuccess != 0)
            $this->success = $mySuccess;
        if ($model->loadAll(Yii::$app->request->post())) {

            if ($model->saveAll()) {

                $this->success = 1; // 1->update erfolgreich
            } else {
                $this->success = -1; // -1->update Fehler
            }
            return $this->render('update', [
                        'model' => $model,
            ]);
        }

        return $this->render('update', array(
                    'model' => $model,
                    'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
        ));
    }

    /**
     * Deletes an existing TabelleDlansprechpartner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->deleteWithChildren();

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
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
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
     * Finds the TabelleDlansprechpartner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabelleDlansprechpartner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabelleDlansprechpartner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwAnsp
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
//    public function actionAddTabelleSwAnsp()
//    {
//        if (Yii::$app->request->isAjax) {
//            $row = Yii::$app->request->post('TabelleSwAnsp');
//            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
//                $row[] = [];
//            return $this->renderAjax('_formTabelleSwAnsp', ['row' => $row]);
//        } else {
//            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//        }
//    }
}
