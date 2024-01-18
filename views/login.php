<?php
/** @var $this \app\core\View */
$this->title = 'Login';
/** @var $model Model */

use app\core\form\Form;
use app\core\Model;

?>
<h1>Login</h1>
<?php $form = Form::begin('','post'); ?>
    <?php echo $form->field($model,'email'); ?>
    <?php echo $form->field($model, 'password'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>
