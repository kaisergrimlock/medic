<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Quản Trị Khách Hàng';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Add Customer Modal -->
<div id="customerModal" class="custom-modal">
    <div class="custom-modal-content">
        <span id="closeModalBtn" class="close">&times;</span>

        <?php $form = ActiveForm::begin(['id' => 'customer-form']); ?>
        <?= $form->field($model, 'ho')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'gioitinh')->dropDownList([0 => 'Nam', 1 => 'Nữ']) ?>
        <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'sodt')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ngaysinh')->input('date') ?>
        <?= $form->field($model, 'doanhso')->input('number') ?>
        <?= $form->field($model, 'ngaydk')->input('date') ?>
        <?= $form->field($model, 'nghenghiep')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Lưu khách hàng', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editCustomerModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close" id="closeEditCustomerModalBtn">&times;</span>
        <?php $editForm = ActiveForm::begin([
            'id' => 'edit-customer-form',
            'action' => ['admin-customer/index'],
            'method' => 'post'
        ]); ?>

        <?= Html::hiddenInput('makh', '', ['id' => 'edit-makh']) ?>

        <?= Html::label('Họ', 'edit-ho') ?>
        <?= Html::textInput('ho', '', ['class' => 'form-control', 'id' => 'edit-ho']) ?>

        <?= Html::label('Tên', 'edit-ten') ?>
        <?= Html::textInput('ten', '', ['class' => 'form-control', 'id' => 'edit-ten']) ?>

        <?= Html::label('Giới Tính', 'edit-gioitinh') ?>
        <?= Html::dropDownList('gioitinh', null, [0 => 'Nam', 1 => 'Nữ'], ['class' => 'form-control', 'id' => 'edit-gioitinh']) ?>

        <?= Html::label('Địa Chỉ', 'edit-diachi') ?>
        <?= Html::textInput('diachi', '', ['class' => 'form-control', 'id' => 'edit-diachi']) ?>

        <?= Html::label('SĐT', 'edit-sodt') ?>
        <?= Html::textInput('sodt', '', ['class' => 'form-control', 'id' => 'edit-sodt']) ?>

        <?= Html::label('Ngày Sinh', 'edit-ngaysinh') ?>
        <?= Html::input('date', 'ngaysinh', '', ['class' => 'form-control', 'id' => 'edit-ngaysinh']) ?>

        <?= Html::label('Doanh Số', 'edit-doanhso') ?>
        <?= Html::input('number', 'doanhso', '', ['class' => 'form-control', 'id' => 'edit-doanhso']) ?>

        <?= Html::label('Ngày ĐK', 'edit-ngaydk') ?>
        <?= Html::input('date', 'ngaydk', '', ['class' => 'form-control', 'id' => 'edit-ngaydk']) ?>

        <?= Html::label('Nghề Nghiệp', 'edit-nghenghiep') ?>
        <?= Html::textInput('nghenghiep', '', ['class' => 'form-control', 'id' => 'edit-nghenghiep']) ?>

        <div class="form-group">
            <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div>
    <?php $searchForm = ActiveForm::begin([
        'method' => 'get',
        'action' => ['admin-customer/index'],
        'options' => ['id' => 'customer-search-form', 'class' => 'form-inline', 'style' => 'margin-bottom: 15px;']
    ]); ?>

    <?= $searchForm->field($model, 'ten')->textInput([
        'placeholder' => 'Tìm khách hàng...',
        'class' => 'form-control mr-2',
        'onkeypress' => "if(event.key === 'Enter'){ this.form.submit(); }"
    ])->label(false) ?>
    <?php ActiveForm::end(); ?>
</div>

<div class="item-list">
    <!-- Trigger Button -->
    <button id="openModalBtn" class="btn btn-primary">Thêm Khách Hàng</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã KH</th>
                <th>Họ</th>
                <th>Tên</th>
                <th>Giới Tính</th>
                <th>Địa Chỉ</th>
                <th>SĐT</th>
                <th>Ngày Sinh</th>
                <th>Doanh Số</th>
                <th>Ngày ĐK</th>
                <th>Nghề Nghiệp</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= Html::encode($customer->makh) ?></td>
                    <td><?= Html::encode($customer->ho) ?></td>
                    <td><?= Html::encode($customer->ten) ?></td>
                    <td><?= $customer->gioitinh ? 'Nữ' : 'Nam' ?></td>
                    <td><?= Html::encode($customer->diachi) ?></td>
                    <td><?= Html::encode($customer->sodt) ?></td>
                    <td><?= Html::encode($customer->ngaysinh) ?></td>
                    <td><?= Html::encode($customer->doanhso) ?></td>
                    <td><?= Html::encode($customer->ngaydk) ?></td>
                    <td><?= Html::encode($customer->nghenghiep) ?></td>
                    <td>
                        <?= Html::tag('button', 'Sửa', [
                            'class' => 'btn btn-warning btn-sm edit-customer-btn',
                            'data-customer' => json_encode([
                                'makh' => $customer->makh,
                                'ho' => $customer->ho,
                                'ten' => $customer->ten,
                                'gioitinh' => $customer->gioitinh,
                                'diachi' => $customer->diachi,
                                'sodt' => $customer->sodt,
                                'ngaysinh' => $customer->ngaysinh,
                                'doanhso' => $customer->doanhso,
                                'ngaydk' => $customer->ngaydk,
                                'nghenghiep' => $customer->nghenghiep
                            ]),
                            'type' => 'button'
                        ]) ?>

                        <?= Html::a('Xóa', ['delete-customer', 'id' => $customer->makh], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Bạn có chắc chắn muốn xóa khách hàng này?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php 
        $currentPage = $pagination->page;
        $pageCount = $pagination->pageCount;
        $firstPageLabel = ($currentPage > 0) ? 'Đầu' : false;
        $lastPageLabel = ($currentPage + 1 < $pageCount) ? 'Cuối' : false;
        $prevPageLabel = ($currentPage > 0) ? '<' : false;
        $nextPageLabel = ($currentPage + 1 < $pageCount) ? '>' : false;

        $start = $pagination->offset + 1;
        $end = $pagination->offset + count($customers);
        $total = $pagination->totalCount;
    ?>
    <div class="pagination-bar">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'firstPageLabel' => $firstPageLabel,
            'lastPageLabel' => $lastPageLabel,
            'prevPageLabel' => $prevPageLabel,
            'nextPageLabel' => $nextPageLabel,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
            'maxButtonCount' => 5,
            'hideOnSinglePage' => true,
        ]) ?>
        <p class="pagination-summary">
            Hiển thị <?= $start ?>–<?= $end ?> trong tổng số <?= $total ?> khách hàng
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("editCustomerModal");
    const closeModalBtn = document.getElementById("closeEditCustomerModalBtn");

    document.querySelectorAll('.edit-customer-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const c = JSON.parse(this.dataset.customer);
            document.getElementById('edit-makh').value = c.makh;
            document.getElementById('edit-ho').value = c.ho;
            document.getElementById('edit-ten').value = c.ten;
            document.getElementById('edit-gioitinh').value = c.gioitinh;
            document.getElementById('edit-diachi').value = c.diachi;
            document.getElementById('edit-sodt').value = c.sodt;
            document.getElementById('edit-ngaysinh').value = c.ngaysinh;
            document.getElementById('edit-doanhso').value = c.doanhso;
            document.getElementById('edit-ngaydk').value = c.ngaydk;
            document.getElementById('edit-nghenghiep').value = c.nghenghiep;
            modal.style.display = "block";
        });
    });

    closeModalBtn.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    document.getElementById("openModalBtn").onclick = function () {
        document.getElementById("customerModal").style.display = "block";
    };

    document.getElementById("closeModalBtn").onclick = function () {
        document.getElementById("customerModal").style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target === document.getElementById("customerModal")) {
            document.getElementById("customerModal").style.display = "none";
        }
    };
});
</script>
