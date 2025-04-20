<?php
use yii\helpers\Html;

$this->title = 'Admin Panel';
?>
<div class="site-admin">
<?php
use yii\widgets\ActiveForm;

$this->title = 'Thêm Khách Hàng';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'makh')->textInput(['maxlength' => true]) ?>
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
        <?= Html::submitButton('Lưu khách hàng', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>