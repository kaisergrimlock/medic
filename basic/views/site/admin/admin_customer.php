<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Quản Trị Khách Hàng';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Modal -->
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

<div>
    <?php $searchForm = ActiveForm::begin([
        'method' => 'get',
        'action' => ['site/admin-customer'], // Adjusted for customer context
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
        // Only show "<" if not on first page
        $prevPageLabel = ($currentPage > 0) ? '<' : false;
        // Only show ">" if not on last page
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

<!-- JS -->
<script>
// When the "openModalBtn" button is clicked, display the modal
document.getElementById("openModalBtn").onclick = function () {
    document.getElementById("customerModal").style.display = "block";
};

// When the "closeModalBtn" button is clicked, hide the modal
document.getElementById("closeModalBtn").onclick = function () {
    document.getElementById("customerModal").style.display = "none";
};

// When clicking anywhere outside the modal, hide the modal
window.onclick = function (event) {
    if (event.target === document.getElementById("customerModal")) {
        document.getElementById("customerModal").style.display = "none";
    }
};
</script>
