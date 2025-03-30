<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;

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
        $makh = Yii::$app->request->get('makh', ''); // Get makh from URL
        $customer = $this->findCustomer($makh); // Fetch customer details

        // Fetch paginated data and pagination object
        list($data, $pagination) = $this->getPaginatedData($makh);

        // Render the view with the data and pagination info
        return $this->render('index', [
            'data' => $data,
            'makh' => $makh,
            'customer' => $customer,
            'pagination' => $pagination,
        ]);
    }

    // Helper method to fetch customer details based on makh
    private function findCustomer($makh)
    {
        if (empty($makh)) {
            return null; // No customer ID provided
        }

        return Yii::$app->db->createCommand("SELECT * FROM khachhang WHERE makh = :makh")
            ->bindValue(':makh', $makh)
            ->queryOne();
    }


    private function getPaginatedData($makh)
    {
        // Base SQL query to retrieve purchased product information grouped by invoice (hoadon.sohd)
            // Base SQL query to retrieve purchased product information
            $sql = "SELECT sanpham.masp, sanpham.tensp, sanpham.dvt, sanpham.nuocsx, sanpham.gia, 
                        cthd.soluong, hoadon.sohd, hoadon.ngayhd
                    FROM khachhang
                    JOIN hoadon ON khachhang.makh = hoadon.makh
                    JOIN cthd ON hoadon.sohd = cthd.sohd
                    JOIN sanpham ON cthd.masp = sanpham.masp";

        // If makh is provided, filter by customer ID
        if (!empty($makh)) {
            $sql .= " WHERE khachhang.makh = :makh";
        }

        // Group by hoadon.sohd to group by invoice
        $sql .= " GROUP BY hoadon.sohd";

        // Get total number of invoices (for pagination)
        $totalCount = Yii::$app->db->createCommand($sql)
            ->bindValue(':makh', $makh)
            ->queryScalar(); // Returns the total number of invoices for pagination

        // Create pagination object
        $pagination = new Pagination([
            'totalCount' => $totalCount,  // Total number of invoices (sohd)
            'pageSize' => 1,             // Number of invoices per page
        ]);
        var_dump($totalCount);

        // Modify query to use LIMIT and OFFSET for pagination (pagination is done per invoice)
        $sql .= " LIMIT :limit OFFSET :offset";
        
        // Fetch the paginated data
        $data = Yii::$app->db->createCommand($sql)
            ->bindValue(':makh', $makh)
            ->bindValue(':limit', $pagination->limit)
            ->bindValue(':offset', $pagination->offset)
            ->queryAll();

        // Return data and pagination object
        return [$data, $pagination];
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
