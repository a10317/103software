<?php

namespace app\controllers;

use Yii;
use app\models\TabelleProdukt;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TabelleProduktController implements the CRUD actions for TabelleProdukt model.
 */
class TabelleProduktController extends Controller
{
    public function behaviors()
    {
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
     * Lists all TabelleProdukt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TabelleProdukt::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabelleProdukt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSws,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerTabelleSw' => $providerTabelleSw,
        ]);
    }

      /**
     * Creates a new TabelleDbversion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabelleProdukt();

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
           
            if ($model->saveAll()) {
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
     * Deletes an existing TabelleProdukt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
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
        $providerTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSws,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerTabelleSw' => $providerTabelleSw,
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
     * Finds the TabelleProdukt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabelleProdukt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabelleProdukt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for TabelleSw
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddTabelleSw()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSw');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSw', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
