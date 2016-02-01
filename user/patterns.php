<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Helpers as Helpers;
use Site\Components as Components;

?>

<?php Components\Page::setTitle('Patterns'); ?>
<?php Components\Page::setIndex('patterns'); ?>
<?php Components\Page::includes('header'); ?>
<?php Components\Page::includes('top'); ?>


<div class="row clearfix">
    <div class="col-sm-5">
        <h1>Patterns</h1>
    </div>
    
    <div class="col-sm-7">
        <div class="page-action">
            
            <div class="col-sm-8 search-form">
                <form action="" method="post">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            
            <div class="col-sm-4 action-btn">
                <a href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Add Pattern</a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Lightbox</td>
                    <td>Value 1</td>
                    <td>Front-end</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lightbox</td>
                    <td>Value 2</td>
                    <td>Front-end</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>