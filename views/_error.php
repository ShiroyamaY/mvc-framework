
<h3><?php
    /** @var \app\core\exception\ForbiddenException $exception */
    echo $exception->getCode();?>
</h3>
<div>
    <?php
        echo $exception->getMessage();
    ?>
</div>