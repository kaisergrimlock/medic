<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Customer_2;
use app\models\Product;
use app\models\Staff;


class SiteController extends Controller
{
    /**
     * Define behaviors for access control and request methods.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users can logout
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'], // Logout should be done via POST request
                ],
            ],
        ];
    }

    /**
     * Define external actions like error handling and CAPTCHA.
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
     * Displays homepage with paginated customer invoices.
     *
     * @return string
     */
    public function actionIndex()
    {
        $makh = Yii::$app->request->get('makh', '');
        $customer = Customer::findById($makh);
        list($data, $pagination) = Customer::getPaginatedInvoices($makh);
    
        return $this->render('index', [
            'data' => $data,
            'makh' => $makh,
            'customer' => $customer,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Login action.
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     */
    public function actionContact()
    {
        $model = new ContactForm();
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
   
    /**
     * Displays about page.
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
