<?php
/** @var $model Model */

use app\core\Model;

?>
<h1>Login</h1>
<?php $form = \app\core\form\Form::begin('','post'); ?>
    <?php echo $form->field($model,'email'); ?>
    <?php echo $form->field($model, 'password'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end();?>
