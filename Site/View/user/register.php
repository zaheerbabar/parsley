<?php
use Site\Helpers as Helpers;

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::setTitle('Register'); ?>
<?php Helpers\Page::setIndex('register'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

<div class="panel user-panel">
    <div class="panel-heading">
        <h1>Registration (Dev Testing)</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <form class="validate" action="" method="post">
                <?=$tokenField?>

                <div class="input-group">
                    <input class="form-control validate[required,custom[email]]" 
                        type="email" name="email" placeholder="Email">
                </div>
                
                <div class="input-group">
                    <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                        type="password" name="pass" placeholder="Password">
                </div>

                <div class="input-group">
                    <input class="form-control validate[required,custom[onlyLetterSp],minSize[3],maxSize[45]]" 
                        type="text" name="first-name" placeholder="First Name">
                </div>
                    
                <div class="input-group">
                    <input class="form-control validate[required,custom[onlyLetterSp],minSize[3],maxSize[45]]" 
                        type="text" name="last-name" placeholder="Last Name">
                </div>
                    
                <div class="input-group">
                    <input class="form-control validate[required,custom[phone]]" 
                        type="tel" name="phone" placeholder="Phone">
                </div>

                <button class="btn" name="_postback" value="1" type="submit">Register</button>
            
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