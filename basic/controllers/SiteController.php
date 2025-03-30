<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        // Get makh from URL parameters
        $makh = Yii::$app->request->get('makh', '');

        // Fetch customer details based on makh
        $customer = $this->findCustomer($makh);

        // SQL query to retrieve purchased product information
        $sql = "SELECT sanpham.masp, sanpham.tensp, sanpham.dvt, sanpham.nuocsx, sanpham.gia, 
                       cthd.soluong, hoadon.sohd, hoadon.ngayhd
                FROM khachhang
                JOIN hoadon ON khachhang.makh = hoadon.makh
                JOIN cthd ON hoadon.sohd = cthd.sohd
                JOIN sanpham ON cthd.masp = sanpham.masp";

        // If a specific makh is provided, filter by customer ID (makh)
        if (!empty($makh)) {
            $sql .= " WHERE khachhang.makh = :makh";
            $data = Yii::$app->db->createCommand($sql)->bindValue(':makh', $makh)->queryAll();
        } else {
            $data = Yii::$app->db->createCommand($sql)->queryAll();
        }

        // Render the index view and pass necessary data
        return $this->render('index', [
            'data' => $data,
            'makh' => $makh,
            'customer' => $customer,
        ]);
    }

    //Find the customer
    private function findCustomer($makh)
    {
        if (empty($makh)) {
            return null; // No customer ID provided
        }

        return Yii::$app->db->createCommand("SELECT * FROM khachhang WHERE makh = :makh")
            ->bindValue(':makh', $makh)
            ->queryOne();
    }

    /**
     * Login action.
     *
     * @return Response|string
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
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
}
