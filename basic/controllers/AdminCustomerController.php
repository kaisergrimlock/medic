<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Customer_2;

class AdminCustomerController extends Controller
{
    public function actionIndex()
    {
        $model = new Customer_2();
        $searchTerm = Yii::$app->request->get('Customer_2')['ten'] ?? null;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Khách hàng mới đã được lưu.');
            return $this->redirect(['index']);
        }

        $paginationData = Customer_2::getPaginatedCustomers(10, $searchTerm);

        return $this->render('//site/admin/admin_customer', [
            'model' => $model,
            'customers' => $paginationData['customers'],
            'pagination' => $paginationData['pagination'],
        ]);
    }

    public function actionUpdateCustomer()
    {
        $request = Yii::$app->request;
        $makh = $request->post('makh');
        $customer = Customer_2::findOne($makh);

        if (!$customer) {
            Yii::$app->session->setFlash('error', 'Khách hàng không tồn tại.');
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }

        if ($customer->updateFromForm($request->post())) {
            Yii::$app->session->setFlash('success', 'Cập nhật khách hàng thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionDeleteCustomer($id)
    {
        $customer = Customer_2::findOne($id);

        if (!$customer) {
            Yii::$app->session->setFlash('error', 'Khách hàng không tồn tại.');
        } else {
            if ($customer->deleteCustomer()) {
                Yii::$app->session->setFlash('success', 'Xóa khách hàng thành công.');
            } else {
                Yii::$app->session->setFlash('error', 'Xóa khách hàng thất bại.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
}
