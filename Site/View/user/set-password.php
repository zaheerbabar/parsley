<?php
use Site\Helper as Helper;
use Site\Objects as Objects;

$tokenField = Helper\Protection::viewPublicTokenField();

?>

<?php Helper\Page::setTitle('Set Password'); ?>
<?php Helper\Page::setIndex('set_password'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div>
    <h2>Change Password</h2>
    
    <form action="" method="post">
        <?=$tokenField?>
        <input type="password" name="new-pass" placeholder="New Password" /> <br/><br/>

        <button class="btn" name="_postback" value="1" type="submit">Set Password</button>
    </form>
    
    <ul>
        <?=Helper\Message::viewLocalList(Objects\MessageType::ERROR)?>
    </ul>

</div>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>