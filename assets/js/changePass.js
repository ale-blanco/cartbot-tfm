var CLASS_INVALID = 'is-invalid';
var CLASS_INVALID_FEEDBACK = 'invalid-feedback';

var myAjax = require('./utils/myAjax');

module.exports = function chagePassInit(btnId, formId) {
    $('#' + btnId).click(function () {
        var data = {};
        $('#' + btnId).prop("disabled", true);
        $('#' + formId)
            .serializeArray()
            .forEach(function (val) {
                data[val.name] = val.value;
            });

        $('#changePassOK').addClass('d-none')
        clearValidationError('password');
        clearValidationError('newPassword');
        clearValidationError('repeatPassword');
        if (!validate(data)) {
            $('#' + btnId).prop("disabled", false);
            return;
        }

        myAjax.put(
            '/a/ax/changepass/',
            data,
            function (data) {
                $('#' + btnId).prop("disabled", false);
                if (data && data.ok === 'ok') {
                    $('#' + formId)[0].reset();
                    $('#changePassOK').removeClass('d-none')
                    return;
                }

                showValidationError('password', 'Error al guardar los datos');
            },
            function(response) {
                $('#' + btnId).prop("disabled", false);
                if (response.status===400) {
                    for (var key in response.responseJSON) {
                        showValidationError(key, response.responseJSON[key]);
                    }
                    return;
                }

                showValidationError('password', 'Error al guardar los datos');
            }
        );
    });
};

function validate(data) {
    var isValid = true;
    if (!data.password) {
        showValidationError('password');
        isValid = false;
    }

    if (!data.newPassword) {
        showValidationError('newPassword');
        isValid = false;
    }

    if (!data.repeatPassword) {
        showValidationError('repeatPassword');
        isValid = false;
    }

    if (isValid && data.newPassword !== data.repeatPassword) {
        showValidationError('newPassword', 'Las contraseñas no son iguales');
        showValidationError('repeatPassword', 'Las contraseñas no son iguales');
        isValid = false;
    }

    return isValid;
}

function showValidationError(id, text) {
    text = text || 'Debe indicar un valor';
    var item = $('#' + id);
    item.addClass(CLASS_INVALID);
    item.parent().find('.' + CLASS_INVALID_FEEDBACK).html(text);
}

function clearValidationError(id) {
    var item = $('#' + id);
    item.removeClass(CLASS_INVALID);
    item.parent().find('.' + CLASS_INVALID_FEEDBACK).html('');
}