<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Components as Components;
use Site\Library\Utilities as Utilities;
use Site\Objects as Objects;
use Site\Handlers as Handlers;
use Site\Helpers as Helpers;

$handler = new Handlers\Project();
$viewData = $handler->viewAll();

$token = Helpers\Protection::viewPrivateToken();

$confirmMessage = Helpers\Message::view($viewData->messages, 'confirm-delete', null);

?>

<?php Helpers\Section::begin('head'); ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<?php Helpers\Section::end(); ?>

<?php Components\Page::setTitle('Projects'); ?>
<?php Components\Page::setIndex('projects'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>

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

<?php if (isset($viewData->messages[Objects\MessageType::SUCCESS])) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::view($viewData->messages, Objects\MessageType::SUCCESS)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::WARNING])) : ?>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Oops!</strong> <?=Helpers\Message::view($viewData->messages, Objects\MessageType::WARNING)?>
</div>
<?php endif; ?>

<?php if (!empty($viewData->data->result)) : ?>
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
                            href="?_page=<?=$viewData->data->page?>&_action=delete&id=<?=$obj->id?>&_token=<?=$token?>">
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
                return confirmAction('{$confirmMessage}');
            });
            
            $('.paging-container').pagination({
                items: {$viewData->data->total},
                cssStyle: '',
                listStyle: 'pagination',
                itemsOnPage: {$viewData->data->limit},
                hrefTextPrefix: '?_page=',
                currentPage: {$viewData->data->page},
                pages: {$viewData->data->pages}
            });
        });
    </script>

<?php Helpers\Section::end(); ?>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>