/* globals Chart:false, feather:false */

(function () {
    'use strict'
    // Graphs
    // Graphs
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chart_labels,//["Jan 1", "Jan 3", "Jan 5", "Jan 7", "Jan 9", "Jan 11", "Jan 13", "Jan 15"],
            datasets: [ chart_dataset ]
            /*{
                label: "Earnings in USD",
                data: [
                    //Math.floor((Math.random()*100) + 1),
                    21,20,22,22,22,22,21
                ],
                borderWidth: 3,
                fill: false,
                pointRadius: 0,
                pointHoverRadius: 0,
                lineTension: 0.5,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBackgroundColor: '#007bff'
            },]*/

        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#999999",
                            fontSize: 11
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                        },
                    },
                ],
                xAxes: [
                    {
                        ticks: {
                            fontColor: "#999999",
                            fontSize: 11
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                        },
                    },
                ],
            },
            tooltips: {
                enabled: false,
                custom: processTooltipModel,
                intersect: false,
                position: "nearest",
                //mode: "index",
            },
            legend: {
                display: false
            }
        }
    });


    function addData(chart, label, data) {
        chart.data.labels.push(label);
        chart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        chart.update();
    }

    function removeData(chart) {
        chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });
        chart.update();
    }

    function processTooltipModel(model) {
        if (!model.body) {
            return;
        }
        const tooltip = document.getElementById("tooltip");
        tooltip.style.left = (model.caretX + 0 ) + "px";
        tooltip.style.top = (model.caretY - 90) + "px";
        tooltip.style.display = "block";
        tooltip.style.setProperty('--background', model.labelColors[0].backgroundColor);
        tooltip.querySelector(".tooltip-label").textContent = model.dataPoints[0].label;
        tooltip.querySelector(".tooltip-value .value").textContent = model.dataPoints[0].value;
    }
})()
