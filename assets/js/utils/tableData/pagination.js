
var page;

module.exports.initPagination = function (callback) {
    page = 1;
    $('.page-item').click(function (event) {
        if ($(event.target).hasClass('disabled')) {
            return;
        }
        var dataPage = $(this).data('page');
        if (dataPage < 1) {
            return;
        }

        page = dataPage;
        callback();
    });
};

module.exports.updatePagination = function (totalRows) {
    var itemByPage = window.cartBot.CONST.itemByPage;
    $('.page-item').each(function (key, item) {
        var jqItem = $(item);
        var isNumeric = jqItem.hasClass('isNumeric');
        var toAdd = jqItem.data('toadd');
        var newPage = page + toAdd;
        if (isNumeric && newPage < key) {
            newPage = key;
        }

        jqItem.removeClass('active');
        jqItem.removeClass('disabled');

        jqItem.data('page', newPage);
        if (isNumeric) {
            $(jqItem[0].children[0]).html(newPage);
        }
        if (newPage === page) {
            jqItem.addClass('active');
        }
        if (newPage < 1 || ((newPage - 1 )* itemByPage) > totalRows ) {
            jqItem.addClass('disabled');
        }
    });

    var from = (page - 1) * itemByPage;
    $('#startRow').html(from + 1);
    var end = from + itemByPage;
    $('#endRow').html((end > totalRows) ? totalRows : end);
};

module.exports.getPage = function () {
    return page;
};

module.exports.setPage = function (newPage) {
    page = newPage;
};