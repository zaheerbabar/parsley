<?php
use Site\Helper as Helper;

?>

<?php Helper\Page::title(Helper\ClientError::title()); ?>
<?php Helper\Page::setIndex('error'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div>
    <h1><?=Helper\ClientError::title()?></h1>

    <p><?=Helper\ClientError::message()?></p>
</div>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>