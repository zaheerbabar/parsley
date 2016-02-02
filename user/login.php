<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User();
$viewData = $userHandler->login();

$tokenField = Helpers\Protection::showPublicTokenField();

?>

<?php Components\Page::setTitle('Login'); ?>
<?php Components\Page::setIndex('login'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Login</h2>

    <form action="" method="post">
        <?=$tokenField?>
        <input type="email" name="email" placeholder="Email" /> <br/>
        <input type="password" name="pass" placeholder="Password" /> <br/><br/>
        <input type="submit" value="Login">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>