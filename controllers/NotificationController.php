<?php

/**
 * -----------------------------------------------
 *  Verfahren: 103Verfahrensverwaltung
 * -----------------------------------------------
 * Controller-Klasse für Tabelle 'Notification'
 *
 * W. Bienert    07.12.2015
 *
 * */

namespace app\controllers;

use Yii;
use app\models\Notification;
use app\models\NotificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller {

    public $success;
    public $inbox;

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
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex($inbox=1) {
        $searchModel = new NotificationSearch();
         $this->inbox = $inbox;
         $queryParams = Yii::$app->request->queryParams;
         

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'inbox' => $inbox,
        ]);
    }

    /**
     * Displays a single Notification model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$inbox) {
        $model = $this->findModel($id);
        $model->isINBOX = $inbox;
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Notification();

        if ($model->loadAll(Yii::$app->request->post())) {
            if ($model->saveAll()) {
                $model->sendMail($model);  // Bestätigungsmail an den Benutzer schicken
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
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @param integer $mySuccess
     * @return mixed
     */
    public function actionUpdate($id, $mySuccess = 0, $inbox = 0) {
        $model = $this->findModel($id);
        $model->isINBOX = $inbox;
        if ($mySuccess != 0)
            $this->success = $mySuccess;
        if ($inbox != 0)
        {
            $this->inbox = $inbox;            
            $model->is_read=1;                
            $model->saveAll();
        }           
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
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
