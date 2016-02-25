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
        
        $('#edit-modal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget);
            var id = link.data('id');
            
            var modal = $(this);
            
            disableModalForm(modal, true, true);
            fetchData(id, modal);  
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