<?php
use Site\Helpers as Helpers;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

$tokenField = Helpers\Protection::viewPublicTokenField();

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="/assets/plugins/validation-engine/validationEngine.jquery.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::setTitle('Account'); ?>
<?php Helpers\Page::setIndex('account'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

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
                
                <form class="edit validate hidden" action="<?=Helpers\Link::route('user/setting/updateprofile', null, true)?>" method="post">
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
                        <button class="btn" type="submit" value="profile">Save</button>
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
                
                <form class="edit validate hidden" action="<?=Helpers\Link::route('user/setting/updatepassword', null, true)?>" method="post">
                    <?=$tokenField?>
                    
                    <div class="col-sm-8 input-group pull-left field">
                        <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                            type="password" name="old-pass" placeholder="Old Password">
                        <input class="form-control validate[required,minSize[6],maxSize[60]]" 
                            type="password" name="new-pass" placeholder="New Password">
                    </div>
                    
                    <div class="action pull-right">
                        <button class="btn" type="submit" value="password">Save</button>
                        <a href="#">Cancel</a>
                    </div>
                    
                    <div class="clearfix"></div>
                
                <?php if (Helpers\Message::isLocalExists('old-pass')) : ?>
                    <div class="row alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=Helpers\Message::viewLocal('old-pass')?>
                    </div>
                <?php endif; ?>
                </form>

            </div>

        </div>
    </div>

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

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::includes('bottom'); ?>
<?php Helpers\Page::includes('footer'); ?>