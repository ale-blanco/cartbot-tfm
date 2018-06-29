var colors = require('./colors');

module.exports.loadBars = function (key, data, listLabels) {
    var labels = [];
    var dataSets = [];
    for (var label in data) {
        if (!data.hasOwnProperty(label)) {
            continue;
        }
        labels.push(label);
        listLabels.forEach(function (val, index) {
            if (!dataSets[index]) {
                dataSets[index] = {
                    label: val,
                    backgroundColor: colors.list[index],
                    data: []
                };
            }

            dataSets[index].data.push(data[label][val] || 0);
        });
    }

    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: dataSets
        },
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: false
            },
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    var ctx = document.getElementById(key).getContext('2d');
    new Chart(ctx, config);
};