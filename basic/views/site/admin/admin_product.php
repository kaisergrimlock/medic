<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thêm Sản Phẩm';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="product-form">

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
