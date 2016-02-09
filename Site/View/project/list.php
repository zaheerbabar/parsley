<?php
use Site\Library\Utilities as Utilities;
use Site\Objects as Objects;
use Site\Helper as Helper;

$token = Helper\Protection::viewPrivateToken();

?>

<?php Helper\Section::begin('head'); ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<?php Helper\Section::end(); ?>

<?php Helper\Page::setTitle('Projects'); ?>
<?php Helper\Page::setIndex('projects'); ?>
<?php Helper\Page::includes('header'); ?>
<?php Helper\Page::includes('top'); ?>

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
                    <td><a href="#" data-toggle="modal" data-target="#view-modal" data-id="<?=$obj->id?>"><?=$obj->title?></a></td>
                    <td><?=Helper\Content::shortDesc($obj->description, 60)?></td>
                    <td><?=Utilities\DateTime::fullDateFormat($obj->creation_date)?></td>
                    <td class="align-center">
                        <a class="btn btn-xs action-btn" data-toggle="modal" data-target="#view-modal" data-id="<?=$obj->id?>" href="#">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-xs action-btn" data-toggle="modal" data-target="#edit-modal" data-id="<?=$obj->id?>" href="#">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-xs action-btn" 
                            href="<?=Helper\Link::route('project/delete', $token, true, ['_page' => $viewData->data->page, 'id' => $obj->id])?>">
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

<!-- Modal -->
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewModalLabel">Project</h4>
      </div>
      <div class="modal-body">

          <h3 class="title">
              <span></span>
              <a href="#" class="btn btn-primary hidden" data-toggle="modal" data-target="#edit-modal" data-id="">Edit</a>
          </h3>
          <p class="creation-date"></p>
          <p class="description"></p>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editModalLabel">Project</h4>
      </div>
      <div class="modal-body">
          
        <form>
            <div class="form-group">
                <label for="title" class="control-label">Project Title</label>
                <input type="text" class="form-control title" id="title">
            </div>

            <label for="creation-date" class="control-label">Creation</label>
            <div class="form-group input-group date">
                <input type="text" class="form-control datepicker creation-date" id="creation-date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea rows="6" class="form-control description" id="description"></textarea>
            </div>
            
            <input type="hidden" class="id" value="">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit">Update</button>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>

<?php Helper\Section::begin('footer'); ?>

    <script src="/assets/plugins/simple-pagination/jquery.simple-pagination.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(function() {

            $('.table .confirm-action').click(function() {
                return confirmAction('<?=Helper\Message::viewLocal('confirm-delete', null)?>');
            });
            
            $('.paging-container').pagination({
                items: <?=$viewData->data->total?>,
                cssStyle: '',
                listStyle: 'pagination',
                itemsOnPage: <?=$viewData->data->limit?>,
                hrefTextPrefix: '<?=Helper\Link::route('project', null, false, ['_page' => ''])?>',
                currentPage: <?=$viewData->data->page?>,
                pages: <?=$viewData->data->pages?>
            });
            
            $('.datepicker').datepicker({
                autoclose: true,
                startDate: '-3y',
                endDate: '+3y',
                todayBtn: 'linked',
                todayHighlight: true
            });
            
            $('#edit-modal').on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget);
                var id = link.data('id');
                
                var modal = $(this);
                
                showData(id, modal);  
            });
            
            $('#edit-modal').on('hidden.bs.modal', function (event) {
                var modal = $(this);
                
                var title = modal.find('.modal-body .title');
                var creation = modal.find('.modal-body .creation-date');
                var desc = modal.find('.modal-body .description');
                
                modal.find('.modal-body .title').val('');
                modal.find('.modal-body .creation-date').val('');
                modal.find('.modal-body .description').text('');
                modal.find('.modal-body .id').val('');
                
                title.prop('disabled', true);
                creation.prop('disabled', true);
                desc.prop('disabled', true);
            });
            
            $('.modal-footer .submit').click(function () {
                $(this).text('Saving...');
                $(this).prop('disabled', true);
                
                var modal = $('#edit-modal');
                modal.data('bs.modal').isShown = false;
                
                var title = modal.find('.modal-body .title');
                var creation = modal.find('.modal-body .creation-date');
                var desc = modal.find('.modal-body .description');
                var id = modal.find('.modal-body .id');
                
                title.prop('disabled', true);
                creation.prop('disabled', true);
                desc.prop('disabled', true);
                
                postAJAX(
                    '?_route=project/update', 
                    '<?=$token?>',
                    {
                        id: id.val(),
                        title: title.val(),
                        creation: creation.val(),
                        description: desc.text()
                    },
                    function (response) {
                        
                        console.log(response);
                    },
                    function (jqXHR, status) {
                        // show error
                        
                        title.prop('disabled', false);
                        creation.prop('disabled', false);
                        desc.prop('disabled', false);
                        
                        $(this).text('Update');
                        $(this).prop('disabled', false);
                        modal.data('bs.modal').isShown = true;
                        console.log(status);
                    }
                );
                
                $btn.button('reset');
            });
            
            $('#view-modal').on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget);
                var id = link.data('id');
                
                var modal = $(this);
                
                showData(id, modal);
            });
            
            $('#view-modal').on('hidden.bs.modal', function (event) {
                var modal = $(this);
                
                modal.find('.modal-body .title span').text('');
                modal.find('.modal-body .creation-date').text('');
                modal.find('.modal-body .description').text('');
                
                var edit = modal.find('.modal-body .title a');
                edit.data('id', 0);
                edit.addClass('hidden');
            });
            
            function showData(id, modal) {
                getAJAX(
                    '?_route=project/get', 
                    '<?=$token?>',
                    {id: id},
                    function (response) {
                        modalId = modal.attr('id');
                    
                        
                        var creation = modal.find('.modal-body .creation-date');
                        var desc = modal.find('.modal-body .description');
                        
                        if (modalId == 'view-modal') {
                            var title = modal.find('.modal-body .title span');
                            var edit = modal.find('.modal-body .title a');
                            
                            edit.data('id', id);
                            edit.removeClass('hidden');
                            title.text(response.data.title);
                            creation.text(response.data.creation_date);
                            desc.text(response.data.description);
                        }
                        else if (modalId == 'edit-modal') {
                            var title = modal.find('.modal-body .title');
                            
                            title.prop('disabled', false);
                            creation.prop('disabled', false);
                            desc.prop('disabled', false);
                            
                            title.val(response.data.title);
                            creation.val(response.data.creation_date);
                            desc.text(response.data.description);
                            modal.find('.modal-body .id').val(id);

                            $('.datepicker').datepicker('update', new Date(response.data.creation_date));
                        }
                    }
                );
            }

        });
    </script>

<?php Helper\Section::end(); ?>

<?php Helper\Page::includes('bottom'); ?>
<?php Helper\Page::includes('footer'); ?>