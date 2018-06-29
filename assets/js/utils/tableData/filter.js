
var self = {
    idTable: null,
    callBack: null,
    lastFilters: ''
};

module.exports.initFilter = function (idTable, callback) {
    self.idTable = idTable;
    self.callBack = callback;
    setEvents();
};

module.exports.getFilters = function () {
    return $('#' + self.idTable + ' .tableFilter input').toArray().reduce(function (carry, item) {
        var jqItem = $(item)[0];
        carry[jqItem.name] = jqItem.value;
        return carry;
    }, {});
};

function filtersStr() {
    return JSON.stringify(module.exports.getFilters());
}

function setEvents() {
    var timerHandle;
    $('#' + self.idTable + ' .tableFilter input').keyup(function () {
        if (self.lastFilters === filtersStr()) {
            return;
        }

        if (timerHandle) {
            clearTimeout(timerHandle);
        }

        timerHandle = setTimeout(function() {
            self.lastFilters = filtersStr();
            self.callBack();
        }, 400);
    });
}