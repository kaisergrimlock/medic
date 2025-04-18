<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-admin">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Welcome to the administration panel. Use the form below to manage customer data:</p>

    <div class="customer-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= $form->field($model, 'makh')->textInput(['placeholder' => 'Customer ID']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Customer Name']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'address')->textInput(['placeholder' => 'Address']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Phone Number']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email Address']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>