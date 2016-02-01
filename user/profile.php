<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;

$profileHandler = new Handlers\Profile();

$viewData = $profileHandler->view();

?>

<?php Components\Page::setPageTitle('Profile'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h2>Profile</h2>
    
    <div class="warning">
        <?=Helpers\Message::showSingle($viewData->messages, 'warning')?>
    </div>

    <form action="" method="post">
        <?=Helpers\Protection::showPublicTokenField()?>

        <input type="text" name="first-name" value="<?=$viewData->data->getFirstName()?>" /> <br/>
        <input type="text" name="last-name" value="<?=$viewData->data->getLastName()?>" /> <br/>
        <input type="tel" name="phone" value="<?=$viewData->data->getPhone()?>" /> <br/><br/>

        <?=Helpers\Content::showImage('abc.jpg', true)?>

        <input type="submit" value="Update">
    </form>
    
    <ul>
        <?=Helpers\Message::messageList($viewData->messages)?>
    </ul>

</div>

<?php Components\Page::includes('footer'); ?>