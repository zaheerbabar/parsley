<?php
use Site\Helper as Helper;
?>

<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div>
    
    <h1>Temp View</h1>
    <ul>
        <?php foreach ($viewData->data as $row) : ?>
            <li><?=$row->title?></li>
        <?php endforeach; ?>
    </ul>

</div>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>