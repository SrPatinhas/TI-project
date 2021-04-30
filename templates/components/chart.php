        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"><span
                            data-feather="calendar"></span>This
                    week
                </button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="myChart" width="400" height="200"></canvas>
            <div id="tooltip">
                <div class="tooltip-label"></div>
                <div class="tooltip-value">
                    <span class="color-circle"></span>
                    <span class="value"></span>
                </div>
            </div>
        </div>

        <div style="max-width: 700px; margin: 40px auto 0 auto;">
            <canvas id="myChart" width="900" height="300" class="my-4 w-100"></canvas>
        </div>