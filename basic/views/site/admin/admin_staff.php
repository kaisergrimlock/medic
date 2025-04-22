<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm Nhân Viên';
?>

<h1><?= Html::encode($this->title) ?></h1>
<div id="customerModal" class="custom-modal">
    <div class="custom-modal-content">
    <span id="closeModalBtn" class="close">&times;</span>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'hoten')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ngayvl')->input('date') ?>
        <?= $form->field($model, 'sodt')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Lưu nhân viên', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div>
    <?php $searchForm = ActiveForm::begin([
        'method' => 'get',
        'action' => ['site/admin-staff'], // Adjusted for staff search
        'options' => ['id' => 'staff-search-form', 'class' => 'form-inline', 'style' => 'margin-bottom: 15px;']
    ]); ?>

    <?= $searchForm->field($model, 'hoten')->textInput([
        'placeholder' => 'Tìm nhân viên...',
        'class' => 'form-control mr-2',
        'onkeypress' => "if(event.key === 'Enter'){ this.form.submit(); }"
    ])->label(false) ?>
    <?php ActiveForm::end(); ?>
</div>

<div>
    <!-- Trigger Button -->
    <button id="openModalBtn" class="btn btn-primary">Thêm Nhân Viên</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ Tên</th>
                <th>Ngày Vào Làm</th>
                <th>Số Điện Thoại</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffs as $staff): ?>
                <tr>
                    <td><?= Html::encode($staff->hoten) ?></td>
                    <td><?= Html::encode($staff->ngayvl) ?></td>
                    <td><?= Html::encode($staff->sodt) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
