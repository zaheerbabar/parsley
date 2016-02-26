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
        <h1>Template: <?=$viewData->data->title?></h1>
    </div>
    
    
    <div class="panel-body">
        <form action="<?=Helper\Link::route('template/save', null, true, ['id' => $viewData->data->id])?>" method="post">
            <?=Helper\Protection::viewPublicTokenField()?>
            
            <div class="row">
                <div class="col-sm-8">
                    <h3>Phases</h3>
    
                    <ul id="phase-list" class="list-group">
                        <?php foreach ($viewData->data->phases as $phase) : ?>
                            <li class="list-group-item">
                                <?=$phase->title?>
                                <input type="hidden" name="phases[]" value="<?=$phase->id?>">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <?php if (empty($viewData->data->phases)) : ?>
                        <div class="alert alert-info col-sm-12" role="alert">
                            <p>No phases added.</p>
                        </div>
                    <?php endif; ?>
                    
                    <a href="#">Add a new phase</a>

                </div>
                
                <div class="col-sm-4">
                    <h4>Settings</h4>
                    <br>
                    <br>
                    <h4>Keywords</h4>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-8">
                    <br>
                    <button class="btn btn-primary col-sm-12" type="submit">Save Template</button>
                </div>
            </div>
        </form>
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
        
        var el = document.getElementById('phase-list');
        var sortable = Sortable.create(el, {
            draggable: '.list-group-item',
            ghostClass: 'sortable-ghost',
            animation: 200
        });
        
    </script>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>