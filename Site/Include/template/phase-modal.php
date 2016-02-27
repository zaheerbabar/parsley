<?php
use Site\Helper as Helper;
use Site\Library\Utilities as Utilities;

$contentTypes = Utilities\Data::arrayObjColumn($viewData->data->content_types, 'title', 'id');

?>
<div class="modal fade" id="new-phase-modal" tabindex="-1" role="dialog" aria-labelledby="newPhaseModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newPhaseModalLabel">New Phase</h4>
      </div>
      <div class="modal-body">
        
        <form class="validate">
            <?=Helper\Protection::viewPublicTokenField()?>
            
            <div class="row">
                <div class="col-sm-12">
                    <div id="contents" class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label">Content Name</label>
                            </div>
                            
                            <div class="col-sm-6">
                                <label class="control-label">Content Type</label>
                            </div>
                        </div>
                        
                        <div class="row content">
                            <div class="col-sm-6">
                                <input type="text" class="form-control validate[required,maxSize[45]]" maxlength="45" name="content-names[]" placeholder="Content Name">
                            </div>
                            
                            <div class="col-sm-5">
                                <select class="form-control validate[required]" name="content-types[]">
                                    <?=Helper\Iteration::viewOptions($contentTypes)?>
                                </select>
                            </div>
                            
                            <div class="col-sm-1 action">
                                <a href="#" class="remove-content hidden"><span class="glyphicon glyphicon-remove"></span></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <a href="#" class="add-content">Add another content type</a>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <div class="form-group">
                        <label for="title" class="control-label">Phase Title</label>
                        <input type="text" class="form-control validate[required,maxSize[45]]" maxlength="45" name="title" id="title"  placeholder="Phase Title">
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="id" value="<?=$viewData->data->id?>">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit">Save</button>
      </div>
    </div>
  </div>
</div>