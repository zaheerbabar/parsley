<?php
use Site\Helper as Helper;

?>

<script src="/assets/plugins/validation-engine/jquery.validationEngine-en.js"></script>
<script src="/assets/plugins/validation-engine/jquery.validationEngine.js"></script>

<script>
    $(function() {
        
        $('.validate').validationEngine('attach', {
            validateNonVisibleFields: true,
            updatePromptsPosition:true,
            scrollOffset: 150
        });
        
        $('#new-modal').on('hidden.bs.modal', function (event) {
            disableModalForm($(this), false, true);
        });
        
        $('#edit-modal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget);
            var id = link.data('id');
            
            var modal = $(this);
            
            disableModalForm(modal, true, true);
            fetchData(id, modal);  
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
                '<?=Helper\Link::routePlain('template/add')?>', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {
                    title: modal.find('.modal-body #title').val(),
                    is_default: modal.find('.modal-body #is-default').prop('checked')
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
                '<?=Helper\Link::routePlain('template/update')?>', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {
                    id: modal.find('.modal-body #id').val(),
                    title: modal.find('.modal-body #title').val(),
                    is_default: modal.find('.modal-body #is-default').prop('checked')
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
        
        function fetchData(id, modal) {
            getAJAX(
                '?_route=template/get', 
                '<?=Helper\Protection::viewPrivateToken()?>',
                {id: id},
                function (response) {
                    console.log(response);
                    enableModalForm(modal, true);
                    populateEditModal(modal, response);
                }
            );
            
        }
        
        function enableModalForm(modal, isUpdate) {
            modal.find('.modal-body #title').prop('disabled', false);
            modal.find('.modal-body #is-default').prop('disabled', false);
        }
        
        function disableModalForm(modal, isUpdate, clear) {
            var title = modal.find('.modal-body #title');
            var isDefault = modal.find('.modal-body #is-default');
            
            if (clear) {
                title.val('');
                isDefault.prop('checked', false);
            }

            title.prop('disabled', true);
            isDefault.prop('disabled', true);
            
            if (isUpdate) {
                if (clear) {
                    modal.find('.modal-body #id').val('');
                }
            }
        }
        
        function populateEditModal(modal, response) {
            modal.find('.modal-body #title').val(response.data.title);
            modal.find('.modal-body #id').val(response.data.id);

            if (response.data.is_default) {
                modal.find('.modal-body #is-default').prop('checked', true);
            }
        }
        
    });
    
</script>