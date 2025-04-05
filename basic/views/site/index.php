<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
?>

<h1 id="index-heading">Thông Tin Khách Hàng</h1>

<!-- Customer Details -->
<div class="customer-details">
    <div class="customer-info-section">
        <div class="customer-info-block">
            <p><strong>Mã KH:</strong></p>
            <form method="GET" action="<?= Url::to(['site/index']) ?>">
                    <input class="customer-info" type="text" name="makh" id="makh" value="<?= Html::encode($makh) ?>" />
            </form>
        </div>
        <div class="customer-info-block">
            <p><strong>Họ KH:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode($customer['ho']) ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
        <div class="customer-info-block">
            <p><strong>Tên KH:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode($customer['ten']) ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
        <div class="customer-info-block">
            <p><strong>Năm Sinh:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode($customer['ngaysinh']) ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
        <div class="customer-info-block">
            <p><strong>Nam:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info" id="gender">
                    <input type="checkbox" <?= $customer['gioitinh'] == 1 ? 'checked' : '' ?> disabled>
                </p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="customer-info-section">
        <div class="customer-info-block">
            <p><strong>Điện thoại:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode($customer['sodt']) ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
        <div class="customer-info-block" id="address">
            <p><strong>Địa chỉ:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode($customer['diachi']) ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
        <div class="customer-info-block">
            <p><strong>Nghề nghiệp:</strong></p>
            <?php if ($customer): ?>
                <p class="customer-info"><?= Html::encode(!empty($customer['nghenghiep']) ? $customer['nghenghiep'] : '') ?></p>
            <?php elseif (!empty($makh)): ?>
                <p></p>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="ops-button-container">
    <button class="ops-button" id="save-button">
        [L]ưu HĐ
    </button>
    <button class="ops-button" id="print-button">
        [I]n HĐ
    </button>
    <button class="ops-button" id="add-button">
        [T]hêm HĐ
    </button>
    <button class="ops-button" id="cust-button">
        Sửa KH [B]
    </button>
</div>

<!-- Purchased Products Table -->
<?php if (!empty($data) && $customer): ?>
    <!-- Invoice Details -->
    <div class="invoice-header">
        <div class="invoice-details">
            <p class="invoice-type"><strong>Số HĐ:</strong></p> <p class="invoice-data"><?= Html::encode($data[0]['sohd']) ?>,</p>
            <p class="invoice-type"><strong>Ngày HĐ:</strong></p> <p class="invoice-data"><?= Html::encode($data[0]['ngayhd']) ?>,</p>
            <p class="invoice-type"><strong>NV bán hàng:</strong></p> <p class="invoice-data"><?= Html::encode($data[0]['hoten']) ?></p>
        </div>

        <!-- Pagination links moved to align right -->
        <div class="pagination-container">
            <div class="pagination-buttons">
                <?php if ($pagination->page > 0): ?>
                    <a href="<?= Url::to(['site/index', 'makh' => $makh, 'page' => $pagination->page]) ?>" class="pagination-button">
                        <span>←</span>
                    </a>
                <?php endif; ?>

                <span class="pagination-info"><?= $pagination->page + 1 ?> / <?= $pagination->pageCount ?></span>

                <?php if ($pagination->page < $pagination->pageCount - 1): ?>
                    <a href="<?= Url::to(['site/index', 'makh' => $makh, 'page' => $pagination->page + 2]) ?>" class="pagination-button">
                        <span>→</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>ĐTV</th>
                <th>Đơn Giá</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= Html::encode($row['masp']) ?></td>
                    <td><?= Html::encode($row['tensp']) ?></td>
                    <td><?= Html::encode($row['dvt']) ?></td>
                    <td><?= Html::encode($row['gia']) ?></td>
                    <td><?= Html::encode($row['soluong']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


<?php else: ?>
    <p>No products found for this customer.</p>
<?php endif; ?>
