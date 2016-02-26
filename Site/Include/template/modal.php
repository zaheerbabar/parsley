<?php
use Site\Helper as Helper;

?>
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editModalLabel">Template</h4>
      </div>
      <div class="modal-body">
        
        <form class="validate">
            <?=Helper\Protection::viewPublicTokenField()?>
            
            <div class="form-group">
                <label for="title" class="control-label">Template Title</label>
                <input type="text" class="form-control validate[required,maxSize[50]]" maxlength="50" name="title" id="title"  placeholder="Template Title">
            </div>
            
            <div class="form-group">
                <input type="checkbox" class="" name="is-default" value="0" id="is-default">
                <label for="is-default" class="control-label">Is default?</label>
            </div>
            
            <input type="hidden" id="id" value="">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="new-modal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newModalLabel">New Template</h4>
      </div>
      <div class="modal-body">
        
        <form class="validate">
            <?=Helper\Protection::viewPublicTokenField()?>
            
            <div class="form-group">
                <label for="title" class="control-label">Template Title</label>
                <input type="text" class="form-control validate[required,maxSize[50]]" maxlength="50" name="title" id="title"  placeholder="Template Title">
            </div>
            
            <div class="form-group">
                <input type="checkbox" class="" name="is-default" value="0" id="is-default">
                <label for="is-default" class="control-label">Is default?</label>
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
