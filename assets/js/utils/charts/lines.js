var colors = require('./colors');

module.exports.loadLines = function (key, data) {
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
        type: 'line',
        data: {
            datasets: [{
                label: 'Productos añadidos',
                data: values,
                backgroundColor: colors.list[0],
                fill: false
            }],
            labels: labels
        },
        options: {
            responsive: true,
            title: {
                display: false
            }
        }
    };

    var ctx = document.getElementById(key).getContext('2d');
    new Chart(ctx, config);
};