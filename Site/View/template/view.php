<?php
use Site\Helper as Helper;
use Site\Objects as Objects;

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
            <div class="row">
                <div class="col-sm-8">
                    <h3>Phases</h3>
                    
                    <ul id="phase-list" class="list-group">
                        <?php foreach ($viewData->data->phases as $phase) : ?>
                            <li class="list-group-item phase-item">
                                <?=$phase->title?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <?php if (empty($viewData->data->phases)) : ?>
                        <div class="alert alert-info col-sm-12 phase-alert" role="alert">
                            <p>No phases added.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <div class="col-sm-4 settings">
                    <section>
                        <h4>Settings</h4>
                            <div class="container">
                            <?php if ($viewData->data->is_default) : ?>
                                <span class="glyphicon glyphicon-ok-circle"></span>
                            <?php else : ?>
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            <?php endif; ?>
                            
                            <span>Default template</span>
                        </div>
                    </section>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <a href="<?=Helper\Link::route('template/edit', null, true, ['id' => $viewData->data->id])?>" class="btn btn-primary col-sm-12">Edit Template</a>
                </div>
            </div>
        </form>
    </div>

</div>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>