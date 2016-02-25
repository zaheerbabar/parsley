<?php
use Site\Helper as Helper;
use Site\Objects as Objects;

$tokenField = Helper\Protection::viewPublicTokenField();
?>

<?php Helper\Page::setTitle('Template'); ?>
<?php Helper\Page::setIndex('template'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div class="panel template-panel">
    <div class="panel-heading">
        <h1>Template</h1>
    </div>
    
    <div class="panel-body">
        <div class="col-sm-4">
            <h3><?=$viewData->data->title?></h3>
                

        </div>
    </div>

</div>

<?php Helper\Section::begin('footer'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js"></script>
    <script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
    <script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>
    <script>
        $('.validate').validationEngine('attach', {
            validateNonVisibleFields: true,
            updatePromptsPosition:true,
            scrollOffset: 150
        });
    </script>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>