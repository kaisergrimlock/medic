<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;

class AdminProductController extends Controller
{
    /**
     * Displays the product admin page with list and add form.
     */
    public function actionIndex()
    {
        $model = new Product();
        $searchTerm = Yii::$app->request->get('Product')['tensp'] ?? null;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sản phẩm mới đã được lưu.');
            return $this->redirect(['index']);
        }

        $result = Product::getPaginatedProducts(10, $searchTerm);

        return $this->render('//site/admin/admin_product', [
            'model' => $model,
            'products' => $result['products'],
            'pagination' => $result['pagination'],
        ]);
    }

    /**
     * Updates an existing product.
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $masp = $request->post('masp');
        $product = Product::findOne($masp);

        if (!$product) {
            Yii::$app->session->setFlash('error', 'Sản phẩm không tồn tại.');
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }

        if ($product->updateFromForm($request->post())) {
            Yii::$app->session->setFlash('success', 'Cập nhật sản phẩm thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Deletes a product.
     *
     * @param int $id
     */
    public function actionDelete($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            Yii::$app->session->setFlash('error', 'Sản phẩm không tồn tại.');
        } else {
            if ($product->deleteProduct()) {
                Yii::$app->session->setFlash('success', 'Xóa sản phẩm thành công.');
            } else {
                Yii::$app->session->setFlash('error', 'Xóa sản phẩm thất bại.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
}
