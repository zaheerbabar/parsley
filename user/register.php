<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$userHandler = new Handlers\User();
$viewData = $userHandler->register();

?>

<?php Components\Page::setTitle('Register'); ?>
<?php Components\Page::setIndex('register'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Register</h2>
    
    <div class="warning">
        <?=Helpers\Message::showSingle($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=Helpers\Protection::showPublicTokenField()?>

        <input type="email" name="email" placeholder="Email" /> <br/>
        <input type="password" name="pass" placeholder="Password" /> <br/><br/>

        <input type="text" name="first-name" placeholder="First Name" /> <br/>
        <input type="text" name="last-name" placeholder="Last Name" /> <br/>
        <input type="tel" name="phone" placeholder="Phone" /> <br/><br/>

        <input type="submit" value="Register">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>