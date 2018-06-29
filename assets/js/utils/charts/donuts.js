var colors = require('./colors');

module.exports.loadDonuts = function (key, data) {
    var labels = [];
    var values = [];
    for (var label in data) {
        if (!data.hasOwnProperty(label)) {
            continue;
        }
        labels.push(label);
        values.push(data[label]);
    }
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: values,
                backgroundColor: colors.list
            }],
            labels: labels
        },
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: false
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