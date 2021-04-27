<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Dashboard"])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "dashboard"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <img src="https://raw.githubusercontent.com/santanu23/IoTDashboard/master/dashboard/images/1.png" alt="img">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>

                    <div class="row row-cols-1">
                        <ul class="list-group">
                            <li class="list-group-item">Sensores</li>
                            <li class="list-group-item"> - Temperatura</li>
                            <li class="list-group-item"> - luz</li>
                            <li class="list-group-item"> - humidade</li>
                            <li class="list-group-item"> - agua no solo</li>
                            <li class="list-group-item"> - Temperatura agua</li>
                            <li class="list-group-item"> - vento</li>

                            <li class="list-group-item">-</li>

                            <li class="list-group-item">Dashboard</li>
                            <li class="list-group-item"> - Adicionar individualmente varios tipos de plantas</li>
                            <li class="list-group-item"> - sensores para cada tipo de planta</li>
                            <li class="list-group-item"> - controlo por web cam para verificar estado de planta</li>
                            <li class="list-group-item"> - notificacoes em caso de avaria ou anomalia</li>
                            <li class="list-group-item"> - estimativa de "vida" de cada planta</li>
                            <li class="list-group-item"> - ligacao a API externa para recolher informacoes conforme a planta escolhida</li>
                        </ul>
                    </div>


                    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
                        <div class="col">
                            <div class="card">
                                <img alt="..." class="card-img-top" src="...">
                                <div class="card-body">
                                    <h5 class="card-title">Tomatoes</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Temperature
                                        <span class="badge bg-primary rounded-pill">24-28ºC</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Humidity
                                        <span class="badge bg-primary rounded-pill">80%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Soil Moisture
                                        <span class="badge bg-primary rounded-pill">50%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Light Intensity
                                        <span class="badge bg-primary rounded-pill">10.000-30.000 lux</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img alt="..." class="card-img-top" src="...">
                                <div class="card-body">
                                    <h5 class="card-title">Tomatoes</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Temperature
                                        <span class="badge bg-primary rounded-pill">24-28ºC</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Humidity
                                        <span class="badge bg-primary rounded-pill">80%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Soil Moisture
                                        <span class="badge bg-primary rounded-pill">50%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Light Intensity
                                        <span class="badge bg-primary rounded-pill">10.000-30.000 lux</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img alt="..." class="card-img-top" src="...">
                                <div class="card-body">
                                    <h5 class="card-title">Tomatoes</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Temperature
                                        <span class="badge bg-primary rounded-pill">24-28ºC</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Humidity
                                        <span class="badge bg-primary rounded-pill">80%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Soil Moisture
                                        <span class="badge bg-primary rounded-pill">50%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Light Intensity
                                        <span class="badge bg-primary rounded-pill">10.000-30.000 lux</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img alt="..." class="card-img-top" src="...">
                                <div class="card-body">
                                    <h5 class="card-title">Tomatoes</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Temperature
                                        <span class="badge bg-primary rounded-pill">24-28ºC</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Humidity
                                        <span class="badge bg-primary rounded-pill">80%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Soil Moisture
                                        <span class="badge bg-primary rounded-pill">50%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Light Intensity
                                        <span class="badge bg-primary rounded-pill">10.000-30.000 lux</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-2">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-header">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="lights_switch">
                                        <label class="form-check-label" for="lights_switch">Ligada</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Luz</h5>
                                    <p class="card-text"></p>
                                    <a href="#" class="btn btn-primary">Ver detalhes</a>
                                </div>
                                <div class="card-footer text-muted">
                                    21kwh gastos nas ultimas 48h
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-header">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="water_switch">
                                        <label class="form-check-label" for="water_switch">Ligada</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Bomba de Agua</h5>
                                    <p class="card-text"></p>
                                    <a href="#" class="btn btn-primary">Ver detalhes</a>
                                </div>
                                <div class="card-footer text-muted">
                                    21 litros gastos nas ultimas 48h
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>

        <?=$this->fetch('./layout/footer.php')?>
        <script src="/assets/js/dashboard.js"></script>
    </body>
</html>
