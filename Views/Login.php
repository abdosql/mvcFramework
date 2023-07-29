<?php
use app\core\form\Form;
/** @var $model = app\Models\ **/
?>

<?php $form = Form::Begin("", "post") ?>
<?php echo $form->field($model, 'email', "Email")?>
<?php echo $form->field($model, 'password', "Password")->TypePassword()?>

<button type="submit" class="btn btn-primary">Register</button>

<?php $form->End()?>
