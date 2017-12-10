<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Users_Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Users_Search;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->model = $this->findModel($id);

        if ($this->model->load(Yii::$app->request->post()) && $this->model->save()) {
            return $this->redirect(['view', 'id' => $this->model->id]);
        } else {
            return $this->render('view', ['model' => $this->model]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User;

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

    // Um abhängige Rollen zwischenzuspeichern
    private $relatedRoleData;
    // Generelles Modell in diesem Controller, damit dieses in den Funktionen nicht immer neu gesucht werden muss
    private $model;

    /**
     * Verschiedene Daten aus der Eingabemaske auswerten...
     */
    private function prepareAbhaengigkeiten() {
        // Überprüfen, ob in der CheckListBox etwas geändert wurde und ggf. die Daten in 
        // einem verschachtelten Array speichern...
        if (isset($_POST['User']['roles'])) {
            $this->relatedRoleData = array(
                'roles' => $_POST['User']['roles'] === '' ? null : $_POST['User']['roles'],
                    //'milestones' => $_POST['Users']['milestones'] === '' ? null : $_POST['Users']['milestones'],
//'projects' => $_POST['Users']['projects'] === '' ? null : $_POST['Users']['projects'],
//'tasks' => $_POST['Users']['tasks'] === '' ? null : $_POST['Users']['tasks'],
//'tasksLists' => $_POST['Users']['tasksLists'] === '' ? null : $_POST['Users']['tasksLists'],
            );
        } else
            $this->relatedRoleData = array('roles' => null);
        // Checkbox überprüfen -> ggf. Konvertierung von String 1 in Int 1
        if (isset($_POST['User']['status'])) {
            $this->model->status = ($_POST['User']['status'] === '1' ? 1 : NULL);
        }

        // Checkbox überprüfen -> ggf. Konvertierung von String 1 in Int 1
        if (isset($_POST['User']['fb_id'])) {
            $this->model->fb_id = $_POST['User']['fb_id'];
        }
    }

    /**
     * Verschiedene Daten aus der Eingabemaske auswerten...
     */
    private function saveAbhaengigkeiten() {
        if (is_array($this->relatedRoleData) && count($this->relatedRoleData) > 0) {
// Unlink all Rollen first
            $this->model->unlinkAll('roles', true);
// Link Rollen                    
            foreach ($this->relatedRoleData as $related) {
                foreach ($related as $role_data) {
                    // Das entsprechende Modell 'Rolle' in der DB finden und mit dem aktuellen User verbinden
                    $this->model->link('roles', \app\models\Role::findOne($role_data)); // Parameter: 1: Relation 2: Modell                                                                                                                        
                }
            }
        }
    }

    /**
     * Updates an existing Role model.
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
            $this->prepareAbhaengigkeiten();
            if ($model->save()) {
                $this->saveAbhaengigkeiten();
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        $this->model->unlinkAll('roles', true);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($this->model = User::findOne($id)) !== null) {
            return $this->model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
