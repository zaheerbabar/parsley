<?php
use Site\Library\Utilities as Utilities;
use Site\Helper as Helper;

?>

<?php Helper\Page::setTitle('Users'); ?>
<?php Helper\Page::setIndex('users'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

<div class="row clearfix">
    
    <div class="col-sm-5">
        <h1>Users</h1>
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
            
                <a href="#" class="btn action-btn"><i class="glyphicon glyphicon-plus"></i> New User</a>
            </div>
 
        </div>
    </div>
    
</div>

<?php if (!empty($viewData->data->result)) : ?>
<div class="row clearfix">
    
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Online</th>
                    <th>Signed Up</th>
                    <th class="align-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($viewData->data->result as $obj) : ?>
                <tr>
                    <td><a href="/project/view.php"><?=$obj->name?></a></td>
                    <td><?=$obj->email?></td>
                    <td><?=Helper\Iteration::implode($obj->roles)?></td>
                    <td><?=Utilities\DateTime::fullTimeFormat($obj->last_online)?></td>
                    <td><?=Utilities\DateTime::fullDateFormat($obj->creation_date)?></td>
                    <td class="align-center">
                        <a class="btn btn-xs action-btn" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs action-btn" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs action-btn" href="#">
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

<?php Helper\Section::begin('footer'); ?>

    <script src="/assets/plugins/simple-pagination/jquery.simple-pagination.js"></script>
    <script>
        $(function() {
            $('.table .confirm-action').click(function() {
                return confirmAction('<?=Helper\Message::viewLocal('confirm-delete', null)?>');
            });
            
       <?php if ($viewData->data->pages > 1) : ?>
            $('.paging-container').pagination({
                items: <?=$viewData->data->total?>,
                cssStyle: '',
                listStyle: 'pagination',
                itemsOnPage: <?=$viewData->data->limit?>,
                hrefTextPrefix: '<?=Helper\Link::route('user/manage', null, false, ['_page' => ''])?>',
                currentPage: <?=$viewData->data->page?>,
                pages: <?=$viewData->data->pages?>
            });
        <?php endif; ?>

        });
    </script>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>