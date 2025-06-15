<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Quản Trị Hệ Thống';
?>

<h1><?= Html::encode($this->title) ?></h1>
<div>
    <div>
        <div class="admin-navigation">
            <p><?= Html::a('Thêm Khách Hàng', ['admin-customer/index'], ['class' => 'btn btn-success']) ?></p>
            <p><?= Html::a('Thêm Sản Phẩm', ['admin-product/index'], ['class' => 'btn btn-primary']) ?></p>
            <p><?= Html::a('Thêm Nhân Viên', ['admin-staff/index'], ['class' => 'btn btn-primary']) ?></p>
        </div>
</div>

