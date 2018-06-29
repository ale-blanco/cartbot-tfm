var myAjax = require('./utils/myAjax');
var pagination = require('./utils/tableData/pagination');
var order = require('./utils/tableData/order');
var filter = require('./utils/tableData/filter');

module.exports = function listEventsInit() {
    $('#dateStart').datetimepicker({
        format: 'DD/MM/YYYY',
        defaultDate: new Date()
    });

    $('#dateEnd').datetimepicker({
        format: 'DD/MM/YYYY',
        defaultDate: new Date()
    });

    $('#findEvents').click(function () {
        pagination.setPage(1);
        loadData();
    });

    pagination.initPagination(function () {
        loadData();
    });

    order.initOrder('tableData', '+date', function () {
        pagination.setPage(1);
        loadData();
    });

    filter.initFilter('tableData', function () {
       loadData();
    });

    function loadData() {
        $('#bodyTable').html('');
        $('#loader').show();
        var parameters = $('form').serialize();
        parameters += '&' + $.param({page: pagination.getPage(), order: order.getOrder()});
        parameters += '&' + $.param(filter.getFilters());
        myAjax.get(
            '/a/ax/findEvents/?' + parameters,
            function (data) {
                $('#loader').hide();
                if (data && data.listEvents) {
                    fillTable(data.listEvents);
                    $('#totalRows').html(data.total);
                    pagination.updatePagination(data.total);
                }
            },
            function() {
                $('#loader').hide();
            }
        );
    }

    function fillTable(data) {
        $('#bodyTable').html('');
        data.forEach(function(val) {
            var tr = document.createElement('tr');
            tr.appendChild(getTd(val.date));
            tr.appendChild(getTd(val.user));
            tr.appendChild(getTd(val.chat));
            tr.appendChild(getTd(val.type));
            tr.appendChild(getTd(val.data));
            $('#bodyTable').append(tr);
        });
    }

    function getTd(value) {
        var td = document.createElement('td');
        td.innerText = value;
        return td;
    }
};
