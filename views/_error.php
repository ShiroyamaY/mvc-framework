<?php
/** @var $exception \app\core\exception\ForbiddenException  */
$code =  $exception->getCode();
/** @var $this \app\core\View */
$this->title = $code;
?>
<h3><?php
    echo $code;?>
</h3>
<div>
    <?php
        echo $exception->getMessage();
    ?>
</div>