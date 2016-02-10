function confirmAction(msg = 'Are you sure?') {
    return window.confirm(msg);
}

function appendSelectOptions(select, data, selectAll) {
    for (var i = 0; i < data.length; i++) {
        var option = document.createElement('option');
        option.value = data[i].id;
        option.innerHTML = data[i].text;
        
        if (selectAll) {
            option.selected = true;
        }
        
        select.append(option);
    }
}