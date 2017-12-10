<?php

namespace app\controllers;

use Yii;
use app\models\TabellePlattform;
use app\models\TabellePlattformSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TabellePlattformController implements the CRUD actions for TabellePlattform model.
 */
class TabellePlattformController extends Controller
{
    
    public $success;
    
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
     * Lists all TabellePlattform models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabellePlattformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabellePlattform model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerTabelleSwPl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwPls,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerTabelleSwPl' => $providerTabelleSwPl,
        ]);
    }

     /**
     * Creates a new TabelleDbversion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabellePlattform();

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
     * Deletes an existing TabellePlattform model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * for export pdf at actionView
     *  
     * @param type $id
     * @return type
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerTabelleSwPl = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwPls,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerTabelleSwPl' => $providerTabelleSwPl,
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
     * Finds the TabellePlattform model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabellePlattform the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabellePlattform::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleSwPl()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwPl');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwPl', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
