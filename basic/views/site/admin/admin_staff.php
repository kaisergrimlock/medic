<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm Nhân Viên';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Add Staff Modal -->
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

<!-- Search -->
<div>
    <?php $searchForm = ActiveForm::begin([
        'method' => 'get',
        'action' => ['site/admin-staff'],
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
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffs as $staff): ?>
                <tr>
                    <td><?= Html::encode($staff->hoten) ?></td>
                    <td><?= Html::encode($staff->ngayvl) ?></td>
                    <td><?= Html::encode($staff->sodt) ?></td>
                    <td>
                        <?= Html::button('Sửa', [
                            'class' => 'btn btn-warning btn-sm edit-btn',
                            'data-staff' => json_encode([
                                'manv' => $staff->manv,
                                'hoten' => $staff->hoten,
                                'ngayvl' => $staff->ngayvl,
                                'sodt' => $staff->sodt,
                            ])
                        ]) ?>
                        <?= Html::a('Xóa', ['delete-staff', 'id' => $staff->manv], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Bạn có chắc chắn muốn xóa nhân viên này?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editStaffModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close" id="closeEditModalBtn">&times;</span>
        <?php $editForm = ActiveForm::begin([
            'id' => 'edit-staff-form',
            'action' => ['site/update-staff'],
            'method' => 'post'
        ]); ?>

        <?= Html::hiddenInput('manv', '', ['id' => 'edit-manv']) ?>
        <?= Html::label('Họ Tên', 'edit-hoten') ?>
        <?= Html::textInput('hoten', '', ['class' => 'form-control', 'id' => 'edit-hoten']) ?>
        <?= Html::label('Ngày Vào Làm', 'edit-ngayvl') ?>
        <?= Html::input('date', 'ngayvl', '', ['class' => 'form-control', 'id' => 'edit-ngayvl']) ?>
        <?= Html::label('Số Điện Thoại', 'edit-sodt') ?>
        <?= Html::textInput('sodt', '', ['class' => 'form-control', 'id' => 'edit-sodt']) ?>

        <div class="form-group">
            <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openModalBtn = document.getElementById("openModalBtn");
        const addModal = document.getElementById("customerModal");
        const closeAddModalBtn = document.getElementById("closeModalBtn");
        const editModal = document.getElementById("editStaffModal");
        const closeEditModalBtn = document.getElementById("closeEditModalBtn");

        openModalBtn.onclick = () => addModal.style.display = "block";
        closeAddModalBtn.onclick = () => addModal.style.display = "none";
        closeEditModalBtn.onclick = () => editModal.style.display = "none";

        window.onclick = function (event) {
            if (event.target === addModal) addModal.style.display = "none";
            if (event.target === editModal) editModal.style.display = "none";
        };

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const staff = JSON.parse(this.dataset.staff);
                document.getElementById('edit-manv').value = staff.manv;
                document.getElementById('edit-hoten').value = staff.hoten;
                document.getElementById('edit-ngayvl').value = staff.ngayvl;
                document.getElementById('edit-sodt').value = staff.sodt;
                editModal.style.display = "block";
            });
        });
    });
</script>
