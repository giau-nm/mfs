var eWaitingStr = '#modal-waiting';
var eWaitingContentStr = '#modal-waiting-content';

$.fn.callAjax = function(params) {
    var currentElement = $(this);
    var elementDisplaySuccess = $("#" + $(this).attr('id') + "-display-success");
    var elementDisplayError = $("#" + $(this).attr('id') + "-display-fail");
    var ajaxParamsDefault = {
        'url': null,
        'data': $(this).is('form')? $(this).serialize() : {},
        'beforeSendCallbackFunction': beforeSendCallbackFunctionDefault,
        'beforeSendCallbackParam' : {
            'elementDisplaySuccess': elementDisplaySuccess,
            'elementDisplayError': elementDisplayError,
            'text': typeof $(this).attr('data-waiting-text') === 'undefined'? loadingText : $(this).attr('data-waiting-text'),
        },

        'successCallbackFunction': successCallbackFunctionDefault,
        'successCallbackParam' : {
            'elementDisplaySuccess': elementDisplaySuccess,
            'elementDisplayError': elementDisplayError,
            'timeoutMs' : 5000,
            'textSuccess': typeof $(this).attr('data-success-text') === 'undefined'? null : $(this).attr('data-success-text'),
            'textFail': typeof $(this).attr('data-fail-text') === 'undefined'? errorReloadPageText : $(this).attr('data-fail-text'),
        },

        'completeCallbackFunction': null,
        'completeCallbackParam' : null,

        'errorCallBackFunction': errorCallBackFunctionDefault,
        'errorCallbackParam' : {
            'elementDisplayError': elementDisplayError,
            'timeoutMs' : 5000,
            'textFail': typeof $(this).attr('data-fail-text') === 'undefined'? errorReloadPageText : $(this).attr('data-fail-text'),
        },
    };

    $.extend(true, ajaxParamsDefault, params);
    params = ajaxParamsDefault;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: findUrlInElement(currentElement, params),
        crossDomain: true,
        type: (typeof currentElement.attr('method') === 'string') ? currentElement.attr('method') : 'GET',
        data: params.data,
        beforeSend: function(jqXHR, settings) {
            var callbackFunction = params.beforeSendCallbackFunction;

            if (typeof callbackFunction !== "function") return null;
            callbackFunction(params.beforeSendCallbackParam);
        },
        success: function(data, textStatus, jqXHR) {
            var callbackFunction = params.successCallbackFunction;

            if (typeof callbackFunction !== "function") return hideModalWait();
            callbackFunction(data, params.successCallbackParam);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            var callbackFunction = params.errorCallBackFunction;
            if (typeof callbackFunction !== "function") return hideModalWait();

            var callbackData = params.errorCallbackParam;
            return callbackFunction(callbackData);
        },
        complete: function(jqXHR, textStatus) {
            var callbackFunction = params.completeCallbackFunction;
            if (typeof callbackFunction === "function") {
                var callbackData = params.completeCallbackFunction;

                if (callbackData === null) {
                    callbackFunction();
                } else {
                    callbackFunction(callbackData);
                }
            }
        }
    });
};

function findUrlInElement(element, params) {
    if (params.url !== null) return params.url;
    if (typeof element.attr('action') === 'string' && element.attr('action') != '' && element.attr('action') != '#') return element.attr('action');
    if (typeof element.attr('href') === 'string' && element.attr('href') != '' && element.attr('href') != '#') return element.attr('href');
    if (typeof element.attr('data-url') === 'string' && element.attr('data-url') != '' && element.attr('data-url') != '#') return element.attr('data-url');
}

function errorCallBackFunctionDefault(callbackData, data) {

    var elementDisplayError = callbackData.elementDisplayError;
    var textFail = callbackData.textFail;
    if (typeof elementDisplayError !== 'object') {
        hideModalWait();
        return null;
    }
    if (elementDisplayError.length > 0)  {
        hideModalWait();
        return displayElementTimeout(elementDisplayError, callbackData.timeoutMs);
    }

    if (typeof textFail === 'string') showModalWait(textFail);
};

function successCallbackFunctionDefault(data, callbackData){
    if (data.success === true) {
        hideModalWait();
        var elementSuccess = callbackData.elementDisplaySuccess;
        if (elementSuccess !== null && typeof elementSuccess === 'object') {
            if (typeof callbackData.textSuccess === 'string') elementSuccess.html(callbackData.textSuccess);
            displayElementTimeout(elementSuccess, callbackData.timeoutMs)
        }
        return false;
    }

    var elementError = callbackData.elementDisplayError;
    if (elementError.length > 0)  {
        hideModalWait();
        return displayElementTimeout(elementError, callbackData.timeoutMs);
    }
    showModalWait(callbackData.textFail)
}

function beforeSendCallbackFunctionDefault(callbackData) {
    if (callbackData.elementDisplaySuccess !== null) callbackData.elementDisplaySuccess.css('display', 'none');
    if (callbackData.elementDisplayError !== null) callbackData.elementDisplayError.css('display', 'none');

    if (typeof callbackData.text === 'string') showModalWait(callbackData.text);
}

function displayElementTimeout(element, timeoutMs) {
    if (typeof element !== "object") return false;

    element.css('display', 'block')
    if (typeof timeoutMs === 'number') {
        window.setTimeout(function() {
            element.slideUp(500, function(){
                $(this).css('display', 'none');
            });
        }, timeoutMs);
    } ;
}

function showModalWait(text) {
    $(eWaitingContentStr).html(text);
    if (!$(eWaitingStr).hasClass('in')) $(eWaitingStr).modal('show');
}

function hideModalWait() {
    if ($(eWaitingStr).hasClass('in')) $(eWaitingStr).modal('hide');
    $(eWaitingContentStr).html('');
}