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
     * Displays admin page.
     */
    public function actionAdminCustomer()
    {
        $model = new Customer_2();
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Khách hàng mới đã được lưu.');
            return $this->redirect(['site/admin-customer']); // Redirected to the same page after saving
        }
    
        // Get paginated customers from the model
        $paginationData = Customer_2::getPaginatedCustomers(10);

        return $this->render('admin/admin_customer', [
            'model' => $model,
            'customers' => $paginationData['customers'],
            'pagination' => $paginationData['pagination'],
        ]);
    }


    public function actionAdminProduct()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sản phẩm mới đã được lưu.');
            return $this->redirect(['site/admin-product']); // Redirected to the same page after saving
        }

        // Get paginated products from the model
        $paginationData = Product::getPaginatedProducts(10);

        return $this->render('admin/admin_product', [
            'model' => $model,
            'products' => $paginationData['products'],
            'pagination' => $paginationData['pagination'],
        ]);
    }

    public function actionAdminStaff()
    {
        $model = new Staff(); // Assuming you have a model for staff as well

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Nhân viên mới đã được lưu.');
            return $this->redirect(['site/admin-staff']); // Corrected redirect URL
        }

        // Get paginated staff from the model
        $paginationData = Staff::getPaginatedStaff(10);

        return $this->render('admin/admin_staff', [
            'model' => $model,
            'staffs' => $paginationData['staffs'],
            'pagination' => $paginationData['pagination'],
        ]);
    }

    public function actionAdmin()
    {
        return $this->render('admin/admin_home');
    }
    
    /**
     * Displays about page.
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
