<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User\Account();
$viewData = $userHandler->setPassword();

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Components\Page::setTitle('Set Password'); ?>
<?php Components\Page::setIndex('set_password'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Change Password</h2>
    
    <div class="warning">
        <?=Helpers\Message::view($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=$tokenField?>
        <input type="password" name="new-pass" placeholder="New Password" /> <br/><br/>
        <input type="submit" value="Set Password">
    </form>
    
    <ul>
        <?=Helpers\Message::viewList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>