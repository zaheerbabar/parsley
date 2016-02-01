<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');
header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');

use Site\Components as Components;

?>

<?php Components\Page::setPageTitle('Forbidden'); ?>
<?php Components\Page::includes('header'); ?>

<div>
    <h1>Forbidden</h1>

    <p>The requested resource is forbidden.</p>
</div>

<?php Components\Page::includes('footer'); ?>