<?php
use Site\Helper as Helper;
use Site\Components as Components;

$user = Components\Auth::getAuthUserData();

$token = Helper\Protection::viewPrivateToken();

?>

<?php Helper\Page::setTitle('Add Template'); ?>
<?php Helper\Page::setIndex('template'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div class="panel user-panel">
    <div class="panel-heading">
        <h1>Add Template</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <form class="validate" action="<?=Helper\Link::route('user/account/login')?>" method="post">
                <?=Helper\Protection::viewPublicTokenField()?>
                
            
            </form>
        </div>
    </div>
    
    <ul>
        <?=Helper\Message::viewLocalList()?>
    </ul>

</div>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>