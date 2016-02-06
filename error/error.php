<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Helpers as Helpers;

?>

<?php Components\Page::title(Helpers\ClientError::title()); ?>
<?php Components\Page::setIndex('error'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h1><?=Helpers\ClientError::title()?></h1>

    <p><?=Helpers\ClientError::message()?></p>
</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>