<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm Nhân Viên';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hoten')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ngayvl')->input('date') ?>
    <?= $form->field($model, 'sodt')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Lưu nhân viên', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
