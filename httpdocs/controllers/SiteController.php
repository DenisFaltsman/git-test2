<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\MyForm;
use app\models\Country;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = 'Hello') {
       return $this->render('say', ['message' => $message]);
   }




   public function actionEntry()
  {
    $model = new EntryForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      // valid data received in $model
      // do something meaningful here about $model ...
      return $this->render('entry-confirm', ['model' => $model]);
    } else {
      // either the page is initially displayed or there is some validation error
      return $this->render('entry', ['model' => $model]);
    }
  }



  public function actionMeeting()
 {
   $form = new MyForm();
   if ($form->load(Yii::$app->request->post()) && $form->validate()) {
    $name = Html::encode($form->name);
    $email = Html::encode($form->email);

    $form->file = UploadedFile::getInstance($form, 'file');
    $form->file->saveAs('photo/' . $form->file->basename.'.'.$form->file->extension);
  } else {
    $name = ''; $email = '';
  }
   return $this->render('myform' , ['model' => $form, 'name' => $name, 'email' => $email]);

 }

 public function actionTest()
{
  return $this->render('test');

}


public function actionCountry() {
  $countries = Country::find()->all();

  return $this->render('country', ['countries' => $countries]);
}

}
