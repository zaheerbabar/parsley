<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Helpers as Helpers;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

$token = Helpers\Protection::showPrivateToken();

?>

<?php Components\Page::setTitle('Home'); ?>
<?php Components\Page::setIndex('home'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div class="row clearfix">
    
    <div class="col-sm-12">
        <h1>Parsley Patterns!</h1>
        
        <p>A pattern management tool and methodology which facilitates the delivery of consistent, best practice, world-class user interfaces.</p>
    </div>
    
</div>

<div class="row clearfix">
    
    <div class="alert alert-info col-sm-12" role="alert">
        <p><strong>Welcome</strong> to the Parsley workflow management system. Features are under development so you can start by using options on the top right corner of the page.</p>
    
        <?php if (Components\Auth::isAuth()) : ?>

        <p>You're logged in as <?=$user->email?>. 
            <a href="user/logout.php?_token=<?=$token?>"><b>Logout</b></a>
        </p>
        
        <?php else: ?>

            <p>You're not logged in.
                <a href="user/login.php"><b>Login</b></a> or 
                <a href="user/register.php"><b>Register</b> (Dev Test)</a>
            </p>

        <?php endif; ?>
    </div>

</div>


<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>