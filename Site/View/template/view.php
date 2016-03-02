<?php
use Site\Helper as Helper;
use Site\Objects as Objects;

?>

<?php Helper\Section::begin('head'); ?>

    <?php Helper\Page::includes('template/phase-modal-style'); ?>
    
<?php Helper\Section::end(); ?>

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
                        <?php for ($i = 0; $i < count($viewData->data->phases); $i++) : ?>
                            <?php 
                                $phase = $viewData->data->phases[$i];
                                $jsonPhase = $viewData->data->json_phases[$i];
                            ?>
                            
                            <li class="list-group-item phase-item">
                                <?=$phase->title?>
                                
                                <input type="hidden" name="phase[]" value="<?=$jsonPhase?>">
                                
                                <ul class="nav navbar-nav navbar-right options">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-option-vertical"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="move-up">Move Up</a></li>
                                            <li><a href="#" class="move-down">Move Down</a></li>
                                            <li><a href="#" class="remove">Remove</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                
                            </li>
                        <?php endfor; ?>
                    </ul>
                    
                    <?php 
                        $alertClass = '';
                        if (empty($viewData->data->phases) == false) {
                            $alertClass = ' hidden';
                        }
                    ?>

                    <div class="alert alert-info col-sm-12 phase-alert<?=$alertClass?>" role="alert">
                        <p>No phases added.</p>
                    </div>
                    
                    <a href="#" data-toggle="modal" data-target="#new-phase-modal">Add a new phase</a>

                </div>
                
                <div class="col-sm-4 settings">
                    <section>
                        <h4>Settings</h4>
                        <?=Helper\Form::viewCheckbox($viewData->data->is_default, 
                            ['id' => 'is-default', 'name' => 'is-default', 'value' => 1])?>
                        <label for="is-default" class="control-label">Default template</label>
                    </section>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <button class="btn btn-primary col-sm-12" type="submit">Save Template</button>
                </div>
            </div>
        </form>
    </div>

</div>

<aside id="views" class="hidden">
    <li class="list-group-item phase-item">
        <span class="title"></span>
        <input type="hidden" name="phase[]" value="">
        
        <ul class="nav navbar-nav navbar-right options">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-option-vertical"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="move-up">Move Up</a></li>
                    <li><a href="#" class="move-down">Move Down</a></li>
                    <li><a href="#" class="remove">Remove</a></li>
                </ul>
            </li>
        </ul>
    </li>
</aside>

<?php Helper\Page::includes('template/phase-modal'); ?>

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
        
        $('#phase-list').on('click', '.move-up', function(event) {
            var phase = $(this).closest('.phase-item');

            if ($(this).prev()) {
                phase.insertBefore(phase.prev());
            }
        });
        
        $('#phase-list').on('click', '.move-down', function(event) {
            var phase = $(this).closest('.phase-item');

            if ($(this).next()) {
                phase.insertAfter(phase.next());
            }
        });
        
        $('#phase-list').on('click', '.remove', function(event) {
            $(this).closest('.phase-item').remove();
            
            if ($('#phase-list').find('.phase-item').length <= 0) {
                $('.phase-alert').removeClass('hidden');
            }
        });
    </script>
    
    <?php Helper\Page::includes('template/phase-modal-script'); ?>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>