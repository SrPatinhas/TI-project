/* globals Chart:false, feather:false */

(function () {
    'use strict'
    feather.replace();
    // Graphs
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan 1", "Jan 3", "Jan 5", "Jan 7", "Jan 9", "Jan 11", "Jan 13", "Jan 15"],
            datasets: [
                {
                    label: "Earnings in USD",
                    data: [
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1)
                    ],
                    borderWidth: 3,
                    fill: false,
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    lineTension: 0.5,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    pointBackgroundColor: '#007bff'
                },
                {
                    label: "Earnings in EUR",
                    data: [
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1),
                        Math.floor((Math.random()*100) + 1)
                    ],
                    borderWidth: 3,
                    fill: false,
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    lineTension: 0.5,
                    backgroundColor: 'transparent',
                    borderColor: '#00ff0d',
                    pointBackgroundColor: '#00ff0d'
                }]
        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#999999",
                            fontSize: 10,
                            callback: (value, index, values) => {
                                if (parseInt(value) >= 1000) {
                                    return "$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return "$" + value;
                                }
                            },
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                ],
                xAxes: [
                    {
                        ticks: {
                            fontColor: "#999999",
                            fontSize: 10,
                            callback: (value, index, values) => {
                                if (parseInt(value) >= 1000) {
                                    return "$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return "$" + value;
                                }
                            },
                        },
                        gridLines: {
                            display: false,
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
        tooltip.style.left = model.caretX + "px";
        tooltip.style.top = model.caretY - 66 - 5 + "px";
        tooltip.style.display = "block";
        tooltip.style.setProperty('--background', model.labelColors[0].backgroundColor);
        tooltip.querySelector(".tooltip-label").textContent = model.dataPoints[0].label;
        tooltip.querySelector(".tooltip-value .value").textContent = "$" + model.dataPoints[0].value;
    }
})()
