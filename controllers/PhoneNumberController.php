<?php

namespace app\controllers;

use Yii;
use app\models\PhoneNumber;
use app\models\PhoneNumberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhoneNumberController implements the CRUD actions for PhoneNumber model.
 */
class PhoneNumberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PhoneNumber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhoneNumberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Creates a new PhoneNumber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PhoneNumber();
        if ($model->load(Yii::$app->request->post())) {
            $contact_id = Yii::$app->request->post('PhoneNumber')['contact_id'];
            if($model->validate()){
                $model->contact_id = $contact_id;
                if($model->save()){
                    return 'success create';
                }else{
                    return 'error save';
                }
            }else{
                $errors = $model->errors;
                $message = '';
                foreach($errors as $k=>$v)
                {
                    // TODO может быть $v[1], .....
                    $message .= $v[0];
                    $message .= '//';
                }
                return $message;
            }
        }
    }
    
    /**
     * Updates an existing PhoneNumber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $contact_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$contact_id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Success update the selected phone number');
                return $this->redirect(['contact/update','id'=>$contact_id]);
            }else{
                Yii::$app->session->setFlash('error',$model->errors );
                return $this->render('update', [
                    'model' => $model
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PhoneNumber model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $contact_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$contact_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['contact/update','id' =>$contact_id,]);
    }

    /**
     * Finds the PhoneNumber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhoneNumber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhoneNumber::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
