<?php
use Site\Helpers as Helpers;

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::setTitle('Login'); ?>
<?php Helpers\Page::setIndex('login'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

<div class="panel user-panel">
    <div class="panel-heading">
        <h1>Login</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <form class="validate" action="" method="post">
                <?=Helpers\Protection::viewPublicTokenField()?>
                
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
                        <a href="<?=Helpers\Link::route('user/account/resetpassword')?>">Forgot your password?</a>
                    </div>
                </div>
                
                <br>
                
                <button class="btn" name="_postback" value="1" type="submit">Login</button>
            
            </form>
        </div>
    </div>
    
    <ul>
        <?=Helpers\Message::viewLocalList()?>
    </ul>

</div>

<?php Helpers\Section::begin('footer'); ?>

    <script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
    <script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>
    <script>
        $('.validate').validationEngine('attach', {
            validateNonVisibleFields: true,
            updatePromptsPosition:true,
            scrollOffset: 150
        });
    </script>

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::includes('bottom'); ?>
<?php Helpers\Page::includes('footer'); ?>