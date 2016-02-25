<?php
use Site\Helper as Helper;

?>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
<script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>

<script>
    $(function() {
        
        $('.datepicker').datepicker({
            autoclose: true,
            startDate: '-3y',
            endDate: '+3y',
            todayBtn: 'linked',
            todayHighlight: true
        });

        $('.validate').validationEngine('attach', {
            validateNonVisibleFields: true,
            updatePromptsPosition:true,
            scrollOffset: 150
        });
        
        $('#new-modal').on('hidden.bs.modal', function (event) {
            disableModalForm($(this), false, true);
        });
        
        $('#new-modal').on('show.bs.modal', function (event) {
            var modal = $(this);
            
            enableModalForm(modal, false);
            bindUserSelector(modal.find('.modal-body .users'));
        });
        
        $('#new-modal .submit').click(function () {
            if ($("#new-modal form").validationEngine('validate') != true) {
                return false;
            }
            
            $(this).text('Saving...');
            $(this).prop('disabled', true);
            
            var modal = $('#new-modal');
            modal.data('bs.modal').isShown = false;
            
            disableModalForm(modal, false, false);
            
            postAJAX(
                '<?=Helper\Link::routePlain('project/add')?>', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {
                    title: modal.find('.modal-body .title').val(),
                    description: modal.find('.modal-body .description').val(),
                    users: modal.find('.modal-body .users').val()
                },
                function (response) {
                    location.reload();
                },
                function (jqXHR, status) {
                    // show error
                    
                    enableModalForm(modal, false);
                    
                    $(this).text('Save');
                    $(this).prop('disabled', false);
                    modal.data('bs.modal').isShown = true;
                    console.log(status);
                }
            );
        });

        $('#edit-modal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget);
            var id = link.data('id');
            
            var modal = $(this);
            
            fetchData(id, modal);  
        });
        
        $('#edit-modal').on('hidden.bs.modal', function (event) {
            disableModalForm($(this), true, true);
        });
        
        $('#edit-modal .submit').click(function () {
            if ($("#edit-modal form").validationEngine('validate') != true) {
                return false;
            }
            
            $(this).text('Saving...');
            $(this).prop('disabled', true);
            
            var modal = $('#edit-modal');
            modal.data('bs.modal').isShown = false;
            
            disableModalForm(modal, true, false);
            
            postAJAX(
                '<?=Helper\Link::routePlain('project/update')?>', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {
                    id: modal.find('.modal-body .id').val(),
                    title: modal.find('.modal-body .title').val(),
                    creation: modal.find('.modal-body .creation-date').val(),
                    description: modal.find('.modal-body .description').val(),
                    users: modal.find('.modal-body .users').val()
                },
                function (response) {
                    location.reload();
                },
                function (jqXHR, status) {
                    // show error
                    
                    enableModalForm(modal, true);
                    
                    $(this).text('Update');
                    $(this).prop('disabled', false);
                    modal.data('bs.modal').isShown = true;
                    console.log(status);
                }
            );
        });
        
        $('#view-modal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget);
            var id = link.data('id');
            
            var modal = $(this);
            
            fetchData(id, modal);
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
        
        function fetchData(id, modal) {
            getAJAX(
                '?_route=project/get', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {id: id},
                function (response) {
                    modalId = modal.attr('id');
                    
                    if (modalId == 'view-modal') {
                        populateViewModal(modal, response);
                    }
                    else if (modalId == 'edit-modal') {
                        enableModalForm(modal, true);
                        populateEditModal(modal, response);
                    }
                }
            );
            
        }
        
        function populateViewModal(modal, response) {
            var edit = modal.find('.modal-body .title a');

            edit.data('id', response.data.id);
            edit.removeClass('hidden');
            modal.find('.modal-body .title span').text(response.data.title);
            modal.find('.modal-body .creation-date').text(response.data.creation_date);
            modal.find('.modal-body .description').text(response.data.description);
        }
        
        function populateEditModal(modal, response) {
            modal.find('.modal-body .title').val(response.data.title);
            modal.find('.modal-body .description').text(response.data.description);
            modal.find('.modal-body .id').val(response.data.id);
            
            var creation = modal.find('.modal-body .creation-date');
            creation.val(response.data.creation_date);
            
            $(creation).datepicker('update', new Date(response.data.creation_date));
            
            var users = modal.find('.modal-body .users');
            appendSelectOptions(users, response.data.users, true);
            bindUserSelector(users);
        }
        
        function bindUserSelector(select) {
            $(select).select2({
                width: '100%',
                minimumInputLength: 3,
                ajax: {
                    url: '<?=Helper\Link::routePlain('project/users', Helper\Protection::viewPrivateToken(), true)?>',
                    processResults: function (response) {
                        var response = JSON.parse(response);
                        return {
                                results: response.data
                            };
                    }
                }
            });
        }
        
        function enableModalForm(modal, isUpdate) {
            
            modal.find('.modal-body .title').prop('disabled', false);
            modal.find('.modal-body .description').prop('disabled', false);
            modal.find('.modal-body .users').prop('disabled', false);
            
            if (isUpdate) {
                modal.find('.modal-body .creation-date').prop('disabled', false);
            }
        }
        
        function disableModalForm(modal, isUpdate, clear) {
            
            var title = modal.find('.modal-body .title');
            var desc = modal.find('.modal-body .description');
            var users = modal.find('.modal-body .users');
            
            if (clear) {
                title.val('');
                desc.text('');
                users.html('');
                users.empty();
            }

            title.prop('disabled', true);
            desc.prop('disabled', true);
            users.prop('disabled', true);
            
            if (isUpdate) {
                var creation = modal.find('.modal-body .creation-date');
                
                if (clear) {
                    modal.find('.modal-body .id').val('');
                    creation.val('');
                }
                
                creation.prop('disabled', true);
            }
        }

    });
</script>