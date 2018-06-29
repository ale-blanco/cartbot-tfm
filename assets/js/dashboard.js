var myAjax = require('./utils/myAjax');
var donuts = require('./utils/charts/donuts');
var bars = require('./utils/charts/bars');
var lines = require('./utils/charts/lines');

module.exports = function dashboardInit() {
    myAjax.get(
        '/a/ax/lastevents/',
        function (data) {
            donuts.loadDonuts('chartByType', data.byType);
            bars.loadBars('chartByHours', data.byHour, data.labels)
        },
        function() {
        }
    );

    myAjax.get(
        '/a/ax/lastseven/',
        function (data) {
            lines.loadLines('chartProducts', data.added);
        },
        function() {
        }
    );
};