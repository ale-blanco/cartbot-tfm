
module.exports.get = function (url, callBackOk, callBackKo) {
    $.get(
        url,
        callBackOk
    ).fail(
        callBackKo
    );
};

module.exports.put = function (url, data, callBackOk, callBackKo) {
    $.ajax({
        url: url,
        type: 'PUT',
        success: callBackOk,
        data: data
    }).fail(
        callBackKo
    );;
};