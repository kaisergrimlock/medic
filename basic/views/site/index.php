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
    <!-- Invoice Details -->
    <div class="invoice-details" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        <h3>Invoice Details</h3>
        <p><strong>Invoice No:</strong> <?= Html::encode($data[0]['sohd']) ?></p>
        <p><strong>Invoice Date:</strong> <?= Html::encode($data[0]['ngayhd']) ?></p>
        <p><strong>staff Name:</strong> <?= Html::encode($data[0]['hoten']) ?></p>
    </div>


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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="pagination-buttons">
        <?php if ($pagination->page > 0): ?>
            <a href="<?= Url::to(['site/index', 'makh' => $makh, 'page' => $pagination->page]) ?>">
                <button>Previous</button>
            </a>
        <?php endif; ?>

        <span> <?= $pagination->page + 1 ?> / <?= $pagination->pageCount ?></span>

        <?php if ($pagination->page < $pagination->pageCount - 1): ?>
            <a href="<?= Url::to(['site/index', 'makh' => $makh, 'page' => $pagination->page + 2]) ?>">
                <button>Next</button>
            </a>
        <?php endif; ?>
    </div>


<?php else: ?>
    <p>No products found for this customer.</p>
<?php endif; ?>
