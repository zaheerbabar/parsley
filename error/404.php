<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');
header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');

use Site\Components as Components;

?>

<?php Components\Page::setPageTitle('Not Found'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h1>Not Found</h1>

    <p>The requested resource was not found.</p>
</div>

<?php Components\Page::includes('footer'); ?>