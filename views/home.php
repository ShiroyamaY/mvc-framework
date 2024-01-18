<?php
/** @var $this \app\core\View */
$this->title = 'Home';
?>
<h1>Home</h1>
<span>
    Hello,<?php echo \app\core\Application::$app->user->firstname ?? 'Guest'; ?>
</span>