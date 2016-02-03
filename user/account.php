<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Helpers as Helpers;
use Site\Components as Components;
use Site\Handlers as Handlers;
use Site\Objects as Objects;

$handler = new Handlers\Account();
$viewData = $handler->view();

$user = Components\Auth::getAuthUserData();

$tokenField = Helpers\Protection::showPublicTokenField();

$markup = <<<HTML
    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">
HTML;

Helpers\Section::add('head', $markup);

?>

<?php Components\Page::setTitle('Account'); ?>
<?php Components\Page::setIndex('account'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>


<?php if (isset($viewData->messages[Objects\MessageType::SUCCESS])) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::SUCCESS)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::ERROR])) : ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Oops!</strong> <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::ERROR)?>
</div>
<?php endif; ?>

<div class="panel settings-panel">
    <div class="panel-heading">
        <h1>My Account</h1>
    </div>


    <div class="row clearfix settings-group">
        <div class="col-sm-4">
            <h3>Personal details</h3>
        </div>
        <div class="col-sm-8">
            <div class="field-container clearfix">
                <div class="field pull-left">
                    <?=$user->email?>
                </div>
            </div>

            <div class="field-container clearfix profile">
                <div class="view">
                    <div class="field pull-left">
                        <div><?=$viewData->data->getFullName()?></div>
                        <div><i><?=$viewData->data->getPhone()?></i></div>
                    </div>
                    
                    <div class="action pull-right">
                        <a href="#edit-profile">Change profile</a>
                    </div>
                </div>
                
                <form class="edit hidden" action="" method="post">
                    <?=$tokenField?>
                    
                    <div class="col-sm-8 input-group pull-left field">
                        <input class="form-control validate[required,custom[onlyLetterSp],minSize[3],maxSize[45]]" 
                            type="text" name="first-name" value="<?=$viewData->data->getFirstName()?>" placeholder="First Name">
                        
                        <input class="form-control validate[required,custom[onlyLetterSp],minSize[3],maxSize[45]]" 
                            type="text" name="last-name" value="<?=$viewData->data->getLastName()?>" placeholder="Last Name">
                            
                            <input class="form-control validate[required,custom[phone]]" 
                            type="tel" name="phone" value="<?=$viewData->data->getPhone()?>" placeholder="Phone">
                    </div>
                    
                    <div class="action pull-right">
                        <button class="btn" type="submit" name="form" value="profile">Save</button>
                        <a href="#">Cancel</a>
                    </div>
                </form>
            </div>
            
            <div class="field-container clearfix password">
                <div class="view">
                    <div class="field pull-left">
                        Password ******
                    </div>
                    
                    <div class="action pull-right">
                        <a href="#edit-pass">Change password</a>
                    </div>
                </div>
                
                <form class="edit hidden" action="" method="post">
                    <?=$tokenField?>
                    
                    <div class="col-sm-8 input-group pull-left field">
                        <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                            type="password" name="old-pass" placeholder="Old Password">
                        <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                            type="password" name="new-pass" placeholder="New Password">
                    </div>
                    
                    <div class="action pull-right">
                        <button class="btn" type="submit" name="form" value="password">Save</button>
                        <a href="#">Cancel</a>
                    </div>
                    
                    <div class="clearfix"></div>
                
                <?php if (isset($viewData->messages['old-pass'])) : ?>
                    <div class="row alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=Helpers\Message::showSingle($viewData->messages, 'old-pass')?>
                    </div>
                <?php endif; ?>
                </form>

            </div>

        </div>
    </div>

</div>

<?php 
$markup = <<<HTML
    <script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
    <script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>
    <script>
        $(".edit").validationEngine();
    
        $(function() {
            $('.settings-group .view .action a').click(function() {
                var field = $(this).parents('.field-container');
                
                field.children('.view').addClass('hidden');
                field.children('.edit').removeClass('hidden');
            });
            
            $('.settings-group .edit .action a').click(function() {
                var field = $(this).parents('.field-container');
                
                field.children('.edit').addClass('hidden');
                field.children('.view').removeClass('hidden');
            });
        });
    </script>
HTML;

Helpers\Section::add('footer', $markup);
?>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>