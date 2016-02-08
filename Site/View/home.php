<?php
use Site\Helper as Helper;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

$token = Helper\Protection::viewPrivateToken();

?>

<?php Helper\Page::setTitle('Home'); ?>
<?php Helper\Page::setIndex('home'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

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
            <a href="<?=Helper\Link::route('user/account/logout', $token, true)?>"><b>Logout</b></a>
        </p>
        
        <?php else: ?>

            <p>You're not logged in.
                <a href="<?=Helper\Link::route('user/account/login')?>"><b>Login</b></a> or 
                <a href="<?=Helper\Link::route('user/account/register')?>"><b>Register</b> (Dev Test)</a>
            </p>

        <?php endif; ?>
    </div>

</div>


<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>