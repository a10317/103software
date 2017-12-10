<?php

/**
 * -----------------------------------------------
 *  Verfahren: 103Verfahrensverwaltung
 * -----------------------------------------------
 * Controller-Klasse für Tabelle 'TabelleRelease'
 *
 * W. Bienert    05.11.2015
 *
 * */

namespace app\controllers;

use Yii;
use app\models\TabelleRelease;
use app\models\TabelleReleaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TabelleReleaseController implements the CRUD actions for TabelleRelease model.
 */
class TabelleReleaseController extends Controller {

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
     * Lists all TabelleRelease models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TabelleReleaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabelleRelease model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $providerTabelleSwFb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwFbs,
        ]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'providerTabelleSwFb' => $providerTabelleSwFb,
        ]);
    }

    /**
     * Creates a new TabelleRelease model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TabelleRelease();

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
     * Updates an existing TabelleRelease model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @param integer $mySuccess
     * @return mixed
     */
    public function actionUpdate($id, $mySuccess = 0) {
        $model = $this->findModel($id);

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
    }

    /**
     * Deletes an existing TabelleRelease model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabelleRelease model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabelleRelease the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TabelleRelease::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
