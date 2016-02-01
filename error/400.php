<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');
header($_SERVER['SERVER_PROTOCOL'].' 403 Bad Request');

use Site\Components as Components;

?>

<?php Components\Page::setPageTitle('Bad Request'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h1>Bad Request</h1>

    <p>Request is not valid.</p>
</div>

<?php Components\Page::includes('footer'); ?>