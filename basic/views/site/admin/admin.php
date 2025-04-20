<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Quản Trị Hệ Thống';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="admin-navigation">
    <p><?= Html::a('Thêm Khách Hàng', ['site/admin-customer'], ['class' => 'btn btn-success']) ?></p>
    <p><?= Html::a('Thêm Sản Phẩm', ['site/admin-product'], ['class' => 'btn btn-primary']) ?></p>
</div>
