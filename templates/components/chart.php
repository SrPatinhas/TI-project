        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h3><?=$title?></h3>
        </div>
        <div class="chart-container">
            <canvas id="myChart" width="900" height="500" class="my-4 w-100"></canvas>
            <div id="tooltip">
                <div class="tooltip-label"></div>
                <div class="tooltip-value">
                    <span class="color-circle"></span>
                    <span class="value"></span>
                </div>
            </div>
        </div>

        <link href="/assets/css/chart.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
        <script>
            const chart_dataset = <?=json_encode($datasets)?>;
            const chart_labels = <?=json_encode($labels)?>;
        </script>
        <script src="/assets/js/chart.js"></script>