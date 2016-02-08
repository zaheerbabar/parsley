<?php
use Site\Library\Utilities as Utilities;
use Site\Objects as Objects;
use Site\Helpers as Helpers;

$token = Helpers\Protection::viewPrivateToken();

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::setTitle('Projects'); ?>
<?php Helpers\Page::setIndex('projects'); ?>
<?php Helpers\Page::includes('header'); ?>
<?php Helpers\Page::includes('top'); ?>

<div class="row clearfix">
    
    <div class="col-sm-5">
        <h1>Projects</h1>
    </div>
    
    <div class="col-sm-7">
        <div class="page-action clearfix">
 
            <div class="navbar-right">
                <form class="navbar-form search-form" role="search">
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            
                <a href="#" class="btn action-btn"><i class="glyphicon glyphicon-plus"></i> New Project</a>
            </div>
 
        </div>
    </div>
    
</div>

<?php if (empty($viewData->data->result) == false) : ?>
<div class="row clearfix">
    
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Creation Date</th>
                    <th class="align-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($viewData->data->result as $obj) : ?>
                <tr>
                    <td><a href="#"><?=$obj->title?></a></td>
                    <td><?=Helpers\Content::shortDesc($obj->description, 60)?></td>
                    <td><?=Utilities\DateTime::fullDateFormat($obj->creation_date)?></td>
                    <td class="align-center">
                        <a class="btn btn-xs action-btn btn-info" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs action-btn btn-warning" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs action-btn btn-danger" 
                            href="<?=Helpers\Link::route('project/delete', $token, true, ['_page' => $viewData->data->page, 'id' => $obj->id])?>">
                            <span class="glyphicon glyphicon-remove confirm-action"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
        
        <nav class="paging-container clearfix"></nav>
        
    </div>
</div>
<?php endif; ?>

<?php Helpers\Section::begin('footer'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/plugins/simple-pagination/jquery.simple-pagination.js"></script>
    <script>
        $(function() {

            $('.table .confirm-action').click(function() {
                return confirmAction('<?=Helpers\Message::viewLocal('confirm-delete', null)?>');
            });
            
            $('.paging-container').pagination({
                items: <?=$viewData->data->total?>,
                cssStyle: '',
                listStyle: 'pagination',
                itemsOnPage: <?=$viewData->data->limit?>,
                hrefTextPrefix: '<?=Helpers\Link::route('project', null, false, ['_page' => ''])?>',
                currentPage: <?=$viewData->data->page?>,
                pages: <?=$viewData->data->pages?>
            });
        });
    </script>

<?php Helpers\Section::end(); ?>

<?php Helpers\Page::includes('bottom'); ?>
<?php Helpers\Page::includes('footer'); ?>