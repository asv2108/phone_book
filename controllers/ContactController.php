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
        $data = [];
        $data['model']=$model;
        //$data['errors']=false;
        $data['success']=false;
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
                    Yii::$app->session->setFlash('success', 'Success, recover from inactive.');
                    return $this->redirect(['index']);
                }else{
                    Yii::$app->session->setFlash('error','Such contact already exist');
                    $data['model']=$contact;
                }
            }else{
                $model->load(Yii::$app->request->post());
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Success create the contact');
                    return $this->redirect(['index']);
                }else{
                    Yii::$app->session->setFlash('error',$model->errors );
                }
            }
        }

        return $this->render('create',$data);
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
        $query = $phone_model->find()->where(['contact_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' =>$query,
        ]);

        $data = [];
        $data['model'] = $model;
        $data['phone_model'] = $phone_model;
        $data['count'] = $query->count();
        $data['dataProvider'] = $dataProvider;
        
        $request = Yii::$app->request;
        if($request->isPost) {
            $post = $request->post('Contact');
            $contact = Contact::find()
                ->where(['first_name' => $post['first_name']])
                ->andWhere(['second_name' => $post['second_name']])
                ->andWhere(['last_name' => $post['last_name']])
                ->one();
            if($contact){
                //$data['model'] = $contact;
                Yii::$app->session->setFlash('error','Such contact already exist');
            }else{
                $model->load(Yii::$app->request->post());
                if($model->validate()){
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Success update the contact');
                    return $this->redirect(['index']);
                }else{
                    $data['model'] = $contact;
                    Yii::$app->session->setFlash('error',$model->errors );
                }
            }
        }

        return $this->render('update',$data);
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
            Yii::$app->session->setFlash('success', 'Success delete the selected contact');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error',$model->errors );
            return $this->redirect(['index']);
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
