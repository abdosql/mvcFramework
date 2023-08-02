<?php
use app\core\form\Form;
?>

<?php $form = Form::Begin("", "post") ?>
  <?php echo $form->InputField($model, 'name', "Full Name")?>
  <?php echo $form->InputField($model, 'email', "Email")?>
  <?php echo $form->InputField($model, 'password', "Password")->TypePassword()?>
  <?php echo $form->InputField($model, 'confirmPassword', "Confirm Your Password")->TypePassword()?>
  <?php echo $form->TextAreaField($model, 'confirmPassword', "Confirm Your Password")?>
  <button type="submit" class="btn btn-primary">Register</button>

<?php $form->End()?>
