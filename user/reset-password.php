<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;
use Site\Handlers as Handlers;
use Site\Objects as Objects;

$userHandler = new Handlers\User\Account();
$viewData = $userHandler->resetPassword();

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Components\Page::setTitle('Reset Password'); ?>
<?php Components\Page::setIndex('reset-password'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<?php if (isset($viewData->messages[Objects\MessageType::SUCCESS])) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::view($viewData->messages, Objects\MessageType::SUCCESS)?>
</div>
<?php endif; ?>

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

                <button class="btn" type="submit">Reset</button>
            
            </form>
        </div>
    </div>
    
    <ul>
        <?=Helpers\Message::viewList($viewData->messages)?>
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

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>