
var order,
    keyOrder,
    tableId,
    callBackChange;

var ASC = '+',
    DESC = '-',
    ORDER_KEY = 'orderkey';

module.exports.initOrder = function (idTable, initialOrder, callBack) {
    order = initialOrder.substr(0, 1);
    tableId = idTable;
    keyOrder = initialOrder.substr(1);
    callBackChange = callBack;
    setIcon();
    setClicks();
};

module.exports.getOrder = function () {
    return order + keyOrder;
};

function setIcon() {
    $('#' + tableId + ' .tableHead i').each(function (key, item) {
        $(item).remove();
    });
    $('#' + tableId + ' .tableHead').each(function (key, item) {
        var jqItem = $(item);
        if (jqItem.data(ORDER_KEY) === keyOrder) {
            var direction = (order === ASC) ? 'down' : 'up';
            jqItem.append('<i class="fa fa-arrow-' + direction + '"></i>');
        }
    });
}

function setClicks() {
    $('#' + tableId + ' .tableHead').each(function (key, item) {
        $(item).click(function () {
            var dataOrderKey = $(this).data(ORDER_KEY);
            if (keyOrder !== dataOrderKey) {
                keyOrder = dataOrderKey;
                order = '+';
            } else {
                order = (order === ASC) ? DESC : ASC;
            }
            setIcon();
            callBackChange();
        });
    });
}
