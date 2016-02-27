<?php
use Site\Helper as Helper;
?>

<script>
    $(function() {
        
        $('#new-phase-modal .add-content').click(function () {
            var modal = $('#new-phase-modal');
            var content = modal.find('#contents > .content:first').clone(true).appendTo('#new-phase-modal #contents');
            content.find('input').val(null);
            content.find('.action .remove-content').removeClass('hidden');
        });
        
        $('#new-phase-modal .action .remove-content').click(function () {
            $(this).closest('.content').remove();
        });
        
        $('#new-phase-modal .submit').click(function () {
            var modal = $('#new-phase-modal');
            if (modal.find('form').validationEngine('validate') != true) {
                return false;
            }
            
            $(this).text('Saving...');
            $(this).prop('disabled', true);

            modal.data('bs.modal').isShown = false;
            disableModalForm(modal, false, false);
            
            postAJAX(
                '<?=Helper\Link::routePlain('template/addphase')?>', 
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
        
        function disableModalForm(modal, isUpdate, clear) {
            var title = modal.find('.modal-body #title');
            var contentName = modal.find('.modal-body #content-name');
            var contentType = modal.find('.modal-body #content-type');
            
            if (clear) {
                title.val('');
                contentName.val('');
                contentType.val('');
            }

            title.prop('disabled', true);
            contentName.prop('disabled', true);
            contentType.prop('disabled', true);            
            
            if (isUpdate) {
                
            }
        }
        
        function enableModalForm(modal, isUpdate) {
            modal.find('.modal-body #title').prop('disabled', false);
            modal.find('.modal-body #content-name').prop('disabled', false);
            modal.find('.modal-body #content-type').prop('disabled', false);
        }
    
    });
</script>