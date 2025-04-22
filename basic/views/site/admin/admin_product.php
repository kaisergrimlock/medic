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
