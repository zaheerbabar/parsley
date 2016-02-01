<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Helpers as Helpers;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

?>

<?php Components\Page::setTitle('Home'); ?>
<?php Components\Page::setIndex('home'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Hello!</h2>

    <p><strong>Welcome</strong> to the Parsley workflow management system. Features are under development so you can start by using options on the top right corner of the page.</p>

    <?php if (Components\Auth::isAuth()) : ?>

    <p>You're logged in as user. 
        <a href="user/logout.php?_token=<?=Helpers\Protection::showPrivateToken()?>">Logout</a></p>

    <a href="user/profile.php">Profile</a> | 
    <a href="user/change-password.php">Change Password</a>

    <?php else: ?>

        <p>You're not logged in. <a href="user/login.php">Login</a> or 
            <a href="user/register.php">Register</a></p>

    <?php endif; ?>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>