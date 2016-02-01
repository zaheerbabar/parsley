<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
?>

<?php Components\Page::setTitle('Thanks'); ?>
<?php Components\Page::setIndex('thanks'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

<div>
    <h2>Thank You!</h2>

    <p>Your account is successfully registered.</p>
    <p>Go to <a href="/index.php">Home</a></p>

</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>