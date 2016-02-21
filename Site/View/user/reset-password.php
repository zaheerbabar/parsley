<?php
use Site\Helper as Helper;
use Site\Objects as Objects;

$tokenField = Helper\Protection::viewPublicTokenField();

?>

<?php Helper\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helper\Section::end(); ?>

<?php Helper\Page::setTitle('Reset Password'); ?>
<?php Helper\Page::setIndex('reset-password'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div class="panel user-panel">
    <div class="panel-heading">
        <h1>Reset Password</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <form class="validate" action="" method="post">
                <?=$tokenField?>
                
                <div class="input-group">
                    <label>Email</label><br>
                    <input class="form-control validate[required,custom[email]]" 
                        type="email" name="email" placeholder="Email">
                </div>

                <button class="btn" name="_postback" value="1" type="submit">Reset</button>
            
            </form>
        </div>
    </div>
    
    <ul>
        <?=Helper\Message::viewLocalList(Objects\MessageType::ERROR)?>
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