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
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="content-name" class="control-label">Content Name</label>
                    <input type="text" class="form-control validate[required,maxSize[45]]" maxlength="45" name="content-name" id="content-name"  placeholder="Content Name">
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="content-type" class="control-label">Content Type</label>
                    <select id="content-type" class="form-control validate[required]" name="content-type">
                        <?=Helper\Iteration::viewOptions($contentTypes)?>
                    </select>
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="title" class="control-label">Phase Title</label>
                    <input type="text" class="form-control validate[required,maxSize[45]]" maxlength="45" name="title" id="title"  placeholder="Phase Title">
                </div>
            </div>
            
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit">Save</button>
      </div>
    </div>
  </div>
</div>