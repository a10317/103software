<?php

namespace app\controllers;

use Yii;
use app\models\tabelle_swtest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Tabelle_swtestController implements the CRUD actions for tabelle_swtest model.
 */
class TabelleSwtestController extends Controller
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
     * Lists all tabelle_swtest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => tabelle_swtest::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tabelle_swtest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerTabelleDbversionHasTabelleSw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleDbversionHasTabelleSws,
        ]);
        $providerTabelleNotiz = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleNotizs,
        ]);
        $providerTabelleSwAnsp = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwAnsps,
        ]);
        $providerTabelleSwDb = new \yii\data\ArrayDataProvider([
            'allModels' => $model->tabelleSwDbs,
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
            'model' => $this->findModel($id),
            'providerTabelleDbversionHasTabelleSw' => $providerTabelleDbversionHasTabelleSw,
            'providerTabelleNotiz' => $providerTabelleNotiz,
            'providerTabelleSwAnsp' => $providerTabelleSwAnsp,
            'providerTabelleSwDb' => $providerTabelleSwDb,
            'providerTabelleSwDl' => $providerTabelleSwDl,
            'providerTabelleSwFb' => $providerTabelleSwFb,
            'providerTabelleSwPl' => $providerTabelleSwPl,
            'providerTabelleSwSn' => $providerTabelleSwSn,
            'providerTabelleWartungsvertrag' => $providerTabelleWartungsvertrag,
        ]);
    }

    /**
     * Creates a new tabelle_swtest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tabelle_swtest();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing tabelle_swtest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing tabelle_swtest model.
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
     * Finds the tabelle_swtest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return tabelle_swtest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = tabelle_swtest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleDbversionHasTabelleSw()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleDbversionHasTabelleSw');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleDbversionHasTabelleSw', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleNotiz()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleNotiz');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleNotiz', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleSwAnsp()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwAnsp');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwAnsp', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleSwDb()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwDb');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwDb', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleSwDl()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwDl');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwDl', ['row' => $row]);
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
    public function actionAddTabelleSwFb()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwFb');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwFb', ['row' => $row]);
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
    
    /**
    * Action to load a tabular form grid
    * for TabelleSwSn
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddTabelleSwSn()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleSwSn');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleSwSn', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    public function actionAddTabelleWartungsvertrag()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('TabelleWartungsvertrag');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('action') == 'load' && empty($row)) || Yii::$app->request->post('action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTabelleWartungsvertrag', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
