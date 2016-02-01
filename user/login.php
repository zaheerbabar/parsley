<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User();
$viewData = $userHandler->login();

?>

<?php Components\Page::setPageTitle('Login'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h2>Login</h2>
    
    <div class="warning">
        <?=Helpers\Message::showSingle($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=Helpers\Protection::showPublicTokenField()?>
        <input type="email" name="email" placeholder="Email" /> <br/>
        <input type="password" name="pass" placeholder="Password" /> <br/><br/>
        <input type="submit" value="Login">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('footer'); ?>