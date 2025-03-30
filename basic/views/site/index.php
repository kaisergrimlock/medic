<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>Customer and Invoice Data</h1>

<!-- Search Form -->
<form method="GET" action="<?= Url::to(['site/index']) ?>">
    <label for="makh">Search by Customer ID (makh):</label>
    <input type="text" name="makh" id="makh" value="<?= Html::encode($makh) ?>" />
    <button type="submit">Search</button>
</form>

<?php if ($customer): ?>
    <div class="customer-details" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        <h3>Customer Details</h3>
        <p><strong>Mã KH:</strong> <?= Html::encode($customer['makh']) ?></p>
        <p><strong>Họ:</strong> <?= Html::encode($customer['ho']) ?></p>
        <p><strong>Tên:</strong> <?= Html::encode($customer['ten']) ?></p>
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

<!-- Display Results -->
<?php if (!empty($data)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <?php foreach (array_keys($data[0]) as $column): ?>
                    <th><?= Html::encode($column) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= Html::encode($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>
