<?php

namespace app\controllers;

use Yii;
use app\models\TabelleSw;
use app\models\TabelleSwSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use c006\alerts\Alerts;

/**
 * TabelleSwController implements the CRUD actions for TabelleSw model.
 */
class TabelleSwController extends Controller {

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
     * Lists all TabelleSw models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabelleSwSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single TabelleSw model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $providerTabelleDbversionHasTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleDbversionHasTabelleSws,
        ]);
        $providerTabelleNotiz = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleNotizs,
        ]);
//        $providerTabelleRelease = new \yii\data\ArrayDataProvider([
//            'allModels' => $model->tabelleReleases,
//        ]);
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps,
        ]);

        $providerTabelleSwDl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwDls,
        ]);
        $providerTabelleSwFb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwFbs,
        ]);
        $providerTabelleSwPl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwPls,
        ]);
        $providerTabelleSwSn = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwSns,
        ]);
        $providerTabelleWartungsvertrag = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleWartungsvertrags,
        ]);


        return $this->render('view', [
                    'model' => $model,
                    'providerTabelleDbversionHasTabelleSw' => $providerTabelleDbversionHasTabelleSw,
                    'providerTabelleNotiz' => $providerTabelleNotiz,
//                    'providerTabelleRelease' => $providerTabelleRelease,
                    'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
//                    'providerTabelleSwDb' => $providerTabelleSwDb,
                    'providerTabelleSwDl' => $providerTabelleSwDl,
                    'providerTabelleSwFb' => $providerTabelleSwFb,
                    'providerTabelleSwPl' => $providerTabelleSwPl,
                    'providerTabelleSwSn' => $providerTabelleSwSn,
                    'providerTabelleWartungsvertrag' => $providerTabelleWartungsvertrag,
        ]);
    }

    /**
     * Creates a new TabelleSw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabelleSw();

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
     * Updates an existing TabelleSw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   public function actionUpdate($id, $mySuccess = 0) {
        $model = $this->findModel($id);

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
     * Deletes an existing TabelleSw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->deleteWithRelated();

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
        $providerTabelleNotiz = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleNotizs,
        ]);
//        $providerTabelleRelease = new \yii\data\ArrayDataProvider([
//            'allModels' => $model->tabelleReleases,
//        ]);
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps,
        ]);
//        $providerTabelleSwDb = new \yii\data\ArrayDataProvider([
//            'allModels' => $model->tabelleSwDbs,
//        ]);
        $providerTabelleSwDl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwDls,
        ]);
        $providerTabelleSwFb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwFbs,
        ]);
        $providerTabelleSwPl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwPls,
        ]);
        $providerTabelleSwSn = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwSns,
        ]);
        $providerTabelleWartungsvertrag = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleWartungsvertrags,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerTabelleDbversionHasTabelleSw' => $providerTabelleDbversionHasTabelleSw,
            'providerTabelleNotiz' => $providerTabelleNotiz,
//            'providerTabelleRelease' => $providerTabelleRelease,
            'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
//            'providerTabelleSwDb' => $providerTabelleSwDb,
            'providerTabelleSwDl' => $providerTabelleSwDl,
            'providerTabelleSwFb' => $providerTabelleSwFb,
            'providerTabelleSwPl' => $providerTabelleSwPl,
            'providerTabelleSwSn' => $providerTabelleSwSn,
            'providerTabelleWartungsvertrag' => $providerTabelleWartungsvertrag,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:16px}',
             
            'options' => ['title' => \Yii::$app->name,
                 'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
                ],
            'methods' => [                
                 'SetHeader' => [\Yii::$app->name.'||Ausdruck vom: ' . date("d.m.Y")],
                 'SetFooter' => ['|Seite {PAGENO}|'],
            ]
        ]);

        return $pdf->render();
    }

//    public function beforeSave($insert) {
//        if (isset($this->password_field))
//            $this->password = Security::generatePasswordHash($this->password_field);
//        return parent::beforeSave($insert);
//    }

    /**
     * Finds the TabelleSw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabelleSw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabelleSw::findOne($id)) !== null) {

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
     * for TabelleNotiz
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleNotiz() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleNotiz');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleNotiz', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleRelease
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
//    public function actionAddTabelleRelease() {
//        if (Yii::$app->request->isAjax) {
//            $row = Yii::$app->request->post('TabelleRelease');
//            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
//                $row[] = [];
//            return $this->renderAjax('_formTabelleRelease', ['row' => $row]);
//        } else {
//            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//        }
//    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwAnsp
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwAnsp() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwAnsp');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwAnsp', ['row' => $row]);
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

    /**
     * Action to load a tabular form grid
     * for TabelleSwDl
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwDl() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwDl');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwDl', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwFb
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwFb() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwFb');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwFb', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwPl
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwPl() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwPl');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwPl', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleSwSn
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleSwSn() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwSn');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwSn', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for TabelleWartungsvertrag
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddTabelleWartungsvertrag() {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleWartungsvertrag');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleWartungsvertrag', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
