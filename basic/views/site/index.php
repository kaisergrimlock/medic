<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager; // Ensure LinkPager is imported
?>

<h1>Customer and Product Purchase Information</h1>

<!-- Search Form -->
<form method="GET" action="<?= Url::to(['site/index']) ?>">
    <label for="makh">Search by Customer ID (makh):</label>
    <input type="text" name="makh" id="makh" value="<?= Html::encode($makh) ?>" />
    <button type="submit">Search</button>
</form>

<!-- Customer Details -->
<?php if ($customer): ?>
    <div class="customer-details" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        <h3>Customer Details</h3>
        <p><strong>Giới Tính:</strong> <?= $customer['gioitinh'] == 1 ? 'Nam' : 'Nữ' ?></p>
        <p><strong>Địa Chỉ:</strong> <?= Html::encode($customer['diachi']) ?></p>
        <p><strong>Số ĐT:</strong> <?= Html::encode($customer['sodt']) ?></p>
        <p><strong>Ngày Sinh:</strong> <?= Html::encode($customer['ngaysinh']) ?></p>
        <p><strong>Doanh Số:</strong> <?= Html::encode($customer['doanhso']) ?></p>
        <p><strong>Ngày Đăng Ký:</strong> <?= Html::encode($customer['ngaydk']) ?></p>
        <p><strong>Nghề Nghiệp:</strong> <?= Html::encode($customer['nghenghiep']) ?></p>
    </div>
<?php elseif (!empty($makh)): ?>
    <p>No customer found with Mã KH: <?= Html::encode($makh) ?></p>
<?php endif; ?>

<!-- Purchased Products Table -->
<?php if (!empty($data)): ?>
    <h3>Purchased Products</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Country</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= Html::encode($row['masp']) ?></td>
                    <td><?= Html::encode($row['tensp']) ?></td>
                    <td><?= Html::encode($row['dvt']) ?></td>
                    <td><?= Html::encode($row['nuocsx']) ?></td>
                    <td><?= Html::encode($row['gia']) ?></td>
                    <td><?= Html::encode($row['soluong']) ?></td>
                    <td><?= Html::encode($row['sohd']) ?></td>
                    <td><?= Html::encode($row['ngayhd']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <?= LinkPager::widget([
        'pagination' => $pagination,  // Make sure pagination object is passed here
    ]) ?>

<?php else: ?>
    <p>No products found for this customer.</p>
<?php endif; ?>
