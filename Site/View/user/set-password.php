<?php
use Site\Helpers as Helpers;

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Helpers\Page::setTitle('Set Password'); ?>
<?php Helpers\Page::setIndex('set_password'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

<div>
    <h2>Change Password</h2>
    
    <form action="" method="post">
        <?=$tokenField?>
        <input type="password" name="new-pass" placeholder="New Password" /> <br/><br/>

        <button class="btn" name="_postback" value="1" type="submit">Set Password</button>
    </form>
    
    <ul>
        <?=Helpers\Message::viewLocalList()?>
    </ul>

</div>

<?php Helpers\Page::includes('bottom'); ?>
<?php Helpers\Page::includes('footer'); ?>