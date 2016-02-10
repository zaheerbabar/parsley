<?php
use Site\Helper as Helper;

$tokenField = Helper\Protection::viewPublicTokenField();
?>

<?php Helper\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helper\Section::end(); ?>

<?php Helper\Page::setTitle('Login'); ?>
<?php Helper\Page::setIndex('login'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div class="panel user-panel">
    <div class="panel-heading">
        <h1>Login</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <form class="validate" action="<?=Helper\Link::route('user/account/login')?>" method="post">
                <?=Helper\Protection::viewPublicTokenField()?>
                
                <div class="input-group">
                    <label>Email</label><br>
                    <input class="form-control validate[required,custom[email]]" 
                        type="email" name="email" placeholder="Email">
                </div>
                
                <div class="input-group">
                    <label>Password</label><br>
                    <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                        type="password" name="pass" placeholder="Password">
                        
                    <div>
                        <a href="<?=Helper\Link::route('user/account/resetpassword')?>">Forgot your password?</a>
                    </div>
                </div>
                
                <br>
                
                <button class="btn" name="_postback" value="1" type="submit">Login</button>
            
            </form>
        </div>
    </div>
    
    <ul>
        <?=Helper\Message::viewLocalList()?>
    </ul>

</div>

<?php Helper\Section::begin('footer'); ?>

    <script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
    <script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>
    <script>
        $('.validate').validationEngine('attach', {
            validateNonVisibleFields: true,
            updatePromptsPosition:true,
            scrollOffset: 150
        });
    </script>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>