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
            
                <a href="#" class="btn action-btn"><i class="glyphicon glyphicon-plus"></i> Add Pattern</a>
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
                    <th class="align-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="#">Lightbox</a></td>
                    <td>Value 1</td>
                    <td>Front-end</td>
                    <td class="align-center">
                        <a class="btn btn-xs btn-info" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs btn-warning" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs btn-danger" href="#">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                
                <tr>
                    <td><a href="#">Lightbox</a></td>
                    <td>Value 1</td>
                    <td>Front-end</td>
                    <td class="align-center">
                        <a class="btn btn-xs btn-info" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs btn-warning" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs btn-danger" href="#">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                
                <tr>
                    <td><a href="#">Lightbox</a></td>
                    <td>Value 1</td>
                    <td>Front-end</td>
                    <td class="align-center">
                        <a class="btn btn-xs btn-info" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs btn-warning" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs btn-danger" href="#">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <nav class="paging-container clearfix">
            <ul class="pagination pull-right">
                <li class="disabled">
                    <a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span> Prev</a>
                </li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">Next <span aria-hidden="true">&raquo;</span></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php Components\Page::includes('bottom'); ?>
<?php Components\Page::includes('footer'); ?>