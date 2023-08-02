<?php
/** @var $this View */

use app\core\View;
use app\core\form\Form;
/** @var $model = app\Models\ **/

$this->setTitle("Login");
?>

<?php $form = Form::Begin("", "post") ?>
<?php echo $form->InputField($model, 'email', "Email")?>
<?php echo $form->InputField($model, 'password', "Password")->TypePassword()?>

<button type="submit" class="btn btn-primary">Register</button>

<?php $form->End()?>
