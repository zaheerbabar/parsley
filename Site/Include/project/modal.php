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
          <p class="description">Loading project...</p>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
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
          
        <form class="validate">
            <div class="form-group">
                <label for="title" class="control-label">Project Title</label>
                <input type="text" class="form-control title validate[required,maxSize[250]]" maxlength="250" id="title"  placeholder="Project Title">
            </div>

            <label for="creation-date" class="control-label">Creation</label>
            <div class="form-group input-group date">
                <input type="text" class="form-control datepicker creation-date validate[required]" id="creation-date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
            
            <label for="users" class="control-label">Users</label>
            <div class="form-group">
                <select class="form-control input-default selector users" multiple="multiple" id="users" placeholder="John Doe">
                </select>
            </div>

            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea rows="6" class="form-control description validate[required,maxSize[5000]]" maxlength="5000" id="description"></textarea>
            </div>
            
            <input type="hidden" class="id" value="">
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newModalLabel">New Project</h4>
      </div>
      <div class="modal-body">
          
        <form class="validate">
            <div class="form-group">
                <label for="title" class="control-label">Project Title</label>
                <input type="text" class="form-control title validate[required,maxSize[250]]" maxlength="250" id="title"  placeholder="Project Title">
            </div>
            
            <label for="users" class="control-label">Users</label>
            <div class="form-group">
                <select class="form-control input-default selector users" multiple="multiple" id="users" placeholder="John Doe">
                </select>
            </div>

            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea rows="6" class="form-control description validate[required,maxSize[5000]]" maxlength="5000" id="description"></textarea>
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