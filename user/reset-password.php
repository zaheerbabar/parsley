<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User();
$viewData = $userHandler->resetPassword();

$tokenField = Helpers\Protection::showPublicTokenField();

?>

<?php Components\Page::setTitle('Reset Password'); ?>
<?php Components\Page::setIndex('reset_password'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Reset Password</h2>
    
    <div class="warning">
        <?=Helpers\Message::showSingle($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=$tokenField?>
        <input type="email" name="email" placeholder="Email" /> <br/><br/>
        <input type="submit" value="Reset">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>