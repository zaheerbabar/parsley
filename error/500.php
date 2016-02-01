<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');
header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');

use Site\Components as Components;

?>

<?php Components\Page::setPageTitle('Server Error'); ?>
<?php Components\Page::setIndex('server_error'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h1>Server Error</h1>

    <p>Internal server error occured.</p>
</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>