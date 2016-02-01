<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User();
$viewData = $userHandler->changePassword();

?>

<?php Components\Page::setPageTitle('Change Password'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h2>Change Password</h2>
    
    <div class="warning">
        <?=Helpers\Message::showSingle($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=Helpers\Protection::showPublicTokenField()?>
        <input type="password" name="old-pass" placeholder="Old Password" /> <br/>
        <input type="password" name="new-pass" placeholder="New Password" /> <br/><br/>
        <input type="submit" value="Change">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('footer'); ?>