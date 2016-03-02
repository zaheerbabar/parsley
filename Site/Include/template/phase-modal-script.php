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
            var form = modal.find('form');
            
            if (form.validationEngine('validate') != true) {
                return false;
            }
            
            var title = form.find('#title').val();
            
            var contentTypes = [];
            modal.find('.modal-body .content').each(function(index) {
                var contentType = {
                    name: $(this).find('.content-name').val(),
                    type_id: $(this).find('.content-type').val()                    
                };
                
                contentTypes.push(contentType);
            });
            
            var phase = {
                title: title,
                content_types: contentTypes
            };
            
            var phaseItem = $('#views .phase-item').first().clone(true);
            phaseItem.find('.title').text(title);
            phaseItem.find('input[name="phase[]"]').first().val(encodeURIComponent(JSON.stringify(phase)));
            
            $('#phase-list').append(phaseItem);
            
            modal.modal('hide');
            reset(modal);
        });
        
        function reset(modal) {
            modal.find('#contents > .content:not(:first)').remove();
            modal.find('.content-name').val('');
            modal.find('.content-type').prop('selectedIndex', 0);
            modal.find('#title').val('');
        }
        
    });
</script>