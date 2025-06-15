<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Quản Trị Hệ Thống';
?>

<?php
$this->registerCssFile('@web/css/admin.css', [
    'depends' => [\yii\web\YiiAsset::class],
]);
?>

<div class="admin-header">
    <h1>Quản Trị Hệ Thống</h1>
</div>

<div class="admin-grid">
    <div class="admin-card">
        <h3>Quản trị khách hàng</h3>
        <p>View and manage the current queue of patients waiting for consultation.</p>
        <?= Html::a('Thêm Khách Hàng', ['admin-customer/index'], ['class' => 'btn-admin']) ?>
    </div>
    <div class="admin-card">
        <h3>Quản trị sản phẩm</h3>
        <p>Manage pharmacy inventory, track medication stock, and update records.</p>
        <?= Html::a('Thêm Sản Phẩm', ['admin-product/index'], ['class' => 'btn-admin']) ?>
    </div>
    <div class="admin-card">
        <h3>Quản trị nhân viên</h3>
        <p>Access and view lists of patients, including their appointment history.</p>
        <?= Html::a('Thêm Nhân Viên', ['admin-staff/index'], ['class' => 'btn-admin']) ?>
    </div>
</div>

