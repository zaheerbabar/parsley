<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Helpers as Helpers;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

?>

<?php Components\Page::setPageTitle('Home'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h2>Hello World!</h2>

    <?php if (Components\Auth::isAuth()) : ?>

    <p>Welcome! You're logged in as user. 
        <a href="user/logout.php?_token=<?=Helpers\Protection::showPrivateToken()?>">Logout</a></p>

    <a href="user/profile.php">Profile</a> | 
    <a href="user/change-password.php">Change Password</a>

    <?php else: ?>

        <p>Welcome! You're not logged in. <a href="user/login.php">Login</a> or 
            <a href="user/register.php">Register</a></p>

    <?php endif; ?>

</div>

<?php Components\Page::includes('footer'); ?>