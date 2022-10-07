<?php

namespace app\controllers;

use app\models\Email;
use app\models\EmailSearch;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EmailsController implements the CRUD actions for Email model.
 */
class EmailsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Email models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Email model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Email model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Email();

        if ($this->request->isPost)
        {
            if ($model->load($this->request->post()))
            {
                $model->save();
                $model->attachment = UploadedFile::getInstance($model, 'attachment');
                //print_r($model->attachment);die();

                if ($model->attachment)
                {
                    $time = time();
                    $model->attachment->saveAs('email_attachments/' . $time . '.' . $model->attachment->extension);
                    $model->attachment = 'email_attachments/' . $time . $model->attachment->extension;
                }
                if ($model->attachment)
                {
                    try {
                        $value = Yii::$app->mailer->compose()
                        ->setFrom(['example@email.com' => "Sender's Name Here"])
                        ->setTo($model->email)
                        ->setSubject($model->subject)
                        ->setHtmlBody($model->content)
                        ->attach($model->attachment)
                        ->send();
                    } catch (ErrorException $e) {
                        Yii::warning($e->getMessage());
                    }
                    
                    //print_r($model->attachment);die();
                }
                else
                {
                    $value = Yii::$app->mailer->compose()
                    ->setFrom(['example@email.com' => "Sender's Name Here"])
                    ->setTo($model->email)
                    ->setSubject($model->subject)
                    ->setHtmlBody($model->content)
                    ->send();
                }

                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Email model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Email model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Email model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Email the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Email::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
