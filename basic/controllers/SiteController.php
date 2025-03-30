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
        $db = Yii::$app->db;
    
        // Step 1: Get distinct invoices (hoadon.sohd) for pagination
        $sqlCount = "SELECT COUNT(DISTINCT hoadon.sohd) 
                     FROM khachhang
                     JOIN hoadon ON khachhang.makh = hoadon.makh
                     JOIN cthd ON hoadon.sohd = cthd.sohd
                     JOIN sanpham ON cthd.masp = sanpham.masp";
    
        if (!empty($makh)) {
            $sqlCount .= " WHERE khachhang.makh = :makh";
        }
    
        $command = $db->createCommand($sqlCount);
        if (!empty($makh)) {
            $command->bindValue(':makh', $makh);
        }
        $totalCount = $command->queryScalar();
    
        // Step 2: Create pagination object
        $pagination = new Pagination([
            'totalCount' => $totalCount ?: 1, // Avoid division by zero
            'pageSize' => 1, // Each page shows one invoice's details
        ]);
    
        // Step 3: Fetch paginated invoices (sohd)
        $sqlSohd = "SELECT DISTINCT hoadon.sohd 
                    FROM hoadon
                    JOIN cthd ON hoadon.sohd = cthd.sohd
                    JOIN sanpham ON cthd.masp = sanpham.masp";
    
        if (!empty($makh)) {
            $sqlSohd .= " WHERE hoadon.makh = :makh";
        }
    
        $sqlSohd .= " LIMIT :limit OFFSET :offset";
    
        $command = $db->createCommand($sqlSohd);
        if (!empty($makh)) {
            $command->bindValue(':makh', $makh);
        }
        $command->bindValue(':limit', $pagination->limit);
        $command->bindValue(':offset', $pagination->offset);
    
        $sohdResults = $command->queryColumn(); // Fetch only `sohd` values
    
        if (empty($sohdResults)) {
            return [[], $pagination]; // No data found
        }
    
        // Step 4: Fetch detailed product purchase information for selected invoices
        $sqlData = "SELECT sanpham.masp, sanpham.tensp, sanpham.dvt, sanpham.nuocsx, sanpham.gia, 
                           cthd.soluong, hoadon.sohd, hoadon.ngayhd
                    FROM hoadon
                    JOIN cthd ON hoadon.sohd = cthd.sohd
                    JOIN sanpham ON cthd.masp = sanpham.masp
                    WHERE hoadon.sohd IN (" . implode(',', array_fill(0, count($sohdResults), '?')) . ")
                    ORDER BY hoadon.sohd";
    
        $command = $db->createCommand($sqlData);
        foreach ($sohdResults as $index => $sohd) {
            $command->bindValue($index + 1, $sohd);
        }
    
        $data = $command->queryAll();
    
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
