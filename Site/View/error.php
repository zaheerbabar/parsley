<?php
use Site\Helpers as Helpers;

?>

<?php Helpers\Page::title(Helpers\ClientError::title()); ?>
<?php Helpers\Page::setIndex('error'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

<div>
    <h1><?=Helpers\ClientError::title()?></h1>

    <p><?=Helpers\ClientError::message()?></p>
</div>

<?php Helpers\Page::includes('bottom'); ?>
<?php Helpers\Page::includes('footer'); ?>