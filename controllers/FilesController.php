<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\File;
use app\models\Files;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * FilesController implements the CRUD actions for File model.
 */
class FilesController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],        
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Files();
        $userModel = new User();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userModel' => $userModel,
            'files_path' => Files::$uploadPath.Yii::$app->user->identity->id.'/',
        ]);
    }

    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'files_path' => Files::$uploadPath.Yii::$app->user->identity->id.'/',
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Files();

        // Setting scenario for proper field validation
        $model->scenario = 'create';

        // We process only POST requests
        if (!Yii::$app->request->isPost || !$model->load(Yii::$app->request->post())) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // We process only POST requests
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // In case it was unsuccessful save or initial Update() access, we display update form
        return $this->render('update', [
            'model' => $model,
            'files_path' => Files::$uploadPath.Yii::$app->user->identity->id.'/',                
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!$model->delete()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
