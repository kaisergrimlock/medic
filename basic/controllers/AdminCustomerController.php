<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Staff;

class AdminCustomerController extends Controller
{
    /**
     * Displays the staff admin page with form and list.
     */
    public function actionIndex()
    {
        $model = new Staff(); // Still using Staff model
        $searchTerm = Yii::$app->request->get('Staff')['hoten'] ?? null;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Nhân viên mới đã được lưu.');
            return $this->redirect(['index']);
        }

        $paginationData = Staff::getPaginatedStaff(10, $searchTerm);

        return $this->render('//site/admin/admin_staff', [
            'model' => $model,
            'staffs' => $paginationData['staffs'],
            'pagination' => $paginationData['pagination'],
        ]);
    }

    /**
     * Updates an existing staff record.
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $manv = $request->post('manv');
        $staff = Staff::findOne($manv);

        if (!$staff) {
            Yii::$app->session->setFlash('error', 'Nhân viên không tồn tại.');
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }

        if ($staff->updateFromForm($request->post())) {
            Yii::$app->session->setFlash('success', 'Cập nhật nhân viên thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Deletes a staff record.
     */
    public function actionDelete($id)
    {
        $staff = Staff::findOne($id);

        if (!$staff) {
            Yii::$app->session->setFlash('error', 'Nhân viên không tồn tại.');
        } else {
            if ($staff->deleteStaff()) {
                Yii::$app->session->setFlash('success', 'Xóa nhân viên thành công.');
            } else {
                Yii::$app->session->setFlash('error', 'Xóa nhân viên thất bại.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
}
