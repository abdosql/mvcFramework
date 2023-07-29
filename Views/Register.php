<?php
use app\core\form\Form;
?>

<?php $form = Form::Begin("", "post") ?>
  <?php echo $form->field($model, 'name', "Full Name")?>
  <?php echo $form->field($model, 'email', "Email")?>
  <?php echo $form->field($model, 'password', "Password")->TypePassword()?>
  <?php echo $form->field($model, 'confirmPassword', "Confirm Your Password")->TypePassword()?>
  <button type="submit" class="btn btn-primary">Register</button>

<?php $form->End()?>
