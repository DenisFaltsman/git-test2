<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php if ($name)  {?>
  <p>you are entered name <?= $name ?> and email <?= $email ?></p>
<?php } ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <?= Html::submitButton('Submit') ?>
<?php ActiveForm::end(); ?>
