function isDefined(input) {
    if (typeof input !== 'undefined') {
        return (input !== null);
    }
    
    return false;
}

$(document).ajaxSend(function(event, request, settings) {
    $('#loading-indicator').show();
});

$(document).ajaxComplete(function(event, request, settings) {
    $('#loading-indicator').hide();
});

function getAJAX(url, token, data, doneCallback, failCallback) {
    requestAJAX(url, 'GET', 'json', token, data, doneCallback, failCallback);
}

function postAJAX(url, token, data, doneCallback, failCallback) {
    requestAJAX(url, 'POST', 'json', token, data, doneCallback, failCallback);
}

function requestAJAX(url, method, dataType, token, data, doneCallback, failCallback) {
    if ($.isPlainObject(data) == false) {
        data = {};
    }

    data._postback = 1;
    if (isDefined(token)) {
        data._token = token;
    }

    var request = $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType
    });
    
    request.done(doneCallback);
 
    request.fail(function(jqXHR, status) {
        if (isDefined(failCallback)) {
            failCallback(jqXHR, status);
        }
        
        console.log('Request failed: ' + status);
    });
}
