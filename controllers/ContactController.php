<?php

namespace app\controllers;

use Yii;
use app\models\Contact;
use app\models\ContactSearch;
use app\models\PhoneNumber;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
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
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();
        $request = Yii::$app->request;
        if($request->isPost)
        {
            $post=$request->post('Contact');
            $contact = Contact::find()
                ->where(['first_name'=>$post['first_name']])
                ->andWhere(['second_name'=>$post['second_name']])
                ->andWhere(['last_name'=>$post['last_name']])
                ->one();
            if($contact){
                if($contact->active == 0){
                    $contact->active = 1;
                    $contact->update();
                    return $this->redirect(['index']);
                }else{
                    return $this->render('create', [
                        'model' => $contact,
                        'errors' => 'Not unique!'
                    ]);
                }
            }else{
                $model->load(Yii::$app->request->post());
                if($model->save()){
                    return $this->redirect(['index']);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                        'errors' => $model->errors
                    ]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $phone_model = new PhoneNumber;
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                return $this->redirect(['index']);
            }else{
                echo "<pre>";
                var_dump($model->errors);
                echo "</pre>";
                exit;
            }
        }

        $query = $phone_model->find()->where(['contact_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' =>$query,
        ]);
        return $this->render('update', [
            'model' => $model,
            'phone_model' =>$phone_model,
            'count' => $query->count(),
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Deletes an existing Contact model and linked phone numbers
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->active = 0;
        if($model->update()!=='false'){
            PhoneNumber::deleteAll(['contact_id' => $id]);
            return $this->redirect(['index']);
        }else{
            echo "<pre>";
            var_dump('Error set the contact to inactive');
            echo "</pre>";
            exit;
        }
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
