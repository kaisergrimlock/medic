<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Thêm Sản Phẩm';
?>

<h1><?= Html::encode($this->title) ?></h1>
<div id="customerModal" class="custom-modal">
    <div class="custom-modal-content">
    <span id="closeModalBtn" class="close">&times;</span>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'tensp')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'dvt')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nuocsx')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'gia')->input('number') ?>

        <div class="form-group">
            <?= Html::submitButton('Lưu sản phẩm', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div>
    <?php $searchForm = ActiveForm::begin([ 
        'method' => 'get',
        'action' => ['site/admin-product'], // Change if needed
        'options' => ['id' => 'product-search-form', 'class' => 'form-inline', 'style' => 'margin-bottom: 15px;']
    ]); ?>

    <?= $searchForm->field($model, 'tensp')->textInput([ 
        'placeholder' => 'Tìm sản phẩm...', 
        'class' => 'form-control mr-2',
        'onkeypress' => "if(event.key === 'Enter'){ this.form.submit(); }"
    ])->label(false) ?>
    <?php ActiveForm::end(); ?>
</div>

<div class="item-list">
    <!-- Trigger Button -->
    <button id="openModalBtn" class="btn btn-primary">Thêm Sản Phẩm</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>ĐVT</th>
                <th>Nước SX</th>
                <th>Giá</th>
                <th>Thao tác</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= Html::encode($product->masp) ?></td>
                    <td><?= Html::encode($product->tensp) ?></td>
                    <td><?= Html::encode($product->dvt) ?></td>
                    <td><?= Html::encode($product->nuocsx) ?></td>
                    <td><?= Html::encode($product->gia) ?></td>
                    <td>
                        <!-- Edit Button -->
                        <?= Html::tag('button', 'Sửa', [
                            'class' => 'btn btn-warning btn-sm edit-btn',
                            'data-product' => json_encode([
                                'masp' => $product->masp,
                                'tensp' => $product->tensp,
                                'dvt' => $product->dvt,
                                'nuocsx' => $product->nuocsx,
                                'gia' => $product->gia,
                            ]),
                            'type' => 'button'
                        ]) ?>

                        <!-- Delete Button with confirmation -->
                        <?= Html::a('Xóa', ['delete', 'id' => $product->masp], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Bạn có chắc chắn muốn xóa sản phẩm này?',
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
        // Only show "<" if not on first page
        $prevPageLabel = ($currentPage > 0) ? '<' : false;
        // Only show ">" if not on last page
        $nextPageLabel = ($currentPage + 1 < $pageCount) ? '>' : false;

        $start = $pagination->offset + 1;
        $end = $pagination->offset + count($products);
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
            Hiển thị <?= $start ?>–<?= $end ?> trong tổng số <?= $total ?> sản phẩm
        </p>
    </div>
</div>

<!-- Edit Modal -->
<div id="editProductModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close" id="closeEditModalBtn">&times;</span>
        <?php $editForm = ActiveForm::begin([
            'id' => 'edit-product-form',
            'action' => ['site/update-product'], // Make sure this route exists
            'method' => 'post'
        ]); ?>

        <?= Html::hiddenInput('masp', '', ['id' => 'edit-masp']) ?>

        <div class="form-group">
            <?= Html::label('Tên SP', 'edit-tensp') ?>
            <?= Html::textInput('tensp', '', ['class' => 'form-control', 'id' => 'edit-tensp']) ?>
        </div>
        <div class="form-group">
            <?= Html::label('ĐVT', 'edit-dvt') ?>
            <?= Html::textInput('dvt', '', ['class' => 'form-control', 'id' => 'edit-dvt']) ?>
        </div>
        <div class="form-group">
            <?= Html::label('Nước SX', 'edit-nuocsx') ?>
            <?= Html::textInput('nuocsx', '', ['class' => 'form-control', 'id' => 'edit-nuocsx']) ?>
        </div>
        <div class="form-group">
            <?= Html::label('Giá', 'edit-gia') ?>
            <?= Html::input('number', 'gia', '', ['class' => 'form-control', 'id' => 'edit-gia']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById("editProductModal");
        const closeModalBtn = document.getElementById("closeEditModalBtn");

        // Bind edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const product = JSON.parse(this.dataset.product);

                document.getElementById('edit-masp').value = product.masp;
                document.getElementById('edit-tensp').value = product.tensp;
                document.getElementById('edit-dvt').value = product.dvt;
                document.getElementById('edit-nuocsx').value = product.nuocsx;
                document.getElementById('edit-gia').value = product.gia;

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
    });
</script>