<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Settings"])?>
        <!-- Custom styles for this template -->
        <link href="/assets/css/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "settings"])?>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Settings</h1>
                    </div>

                    <form>
                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="range-wrap">
                                    <label for="range_temperature" class="form-label">Temperature % for the window to open</label>
                                    <div class="range-value form-label" id="range_temperature_label"></div>
                                    <input id="range_temperature" class="form-range" type="range" min="-100" max="100" value="0" step="1" oninput="showVal('range_temperature', ' ºC')">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkbox_temperature">
                                    <label class="form-check-label" for="checkbox_temperature">Always Open</label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="range-wrap">
                                    <label for="range_humidity" class="form-label">Humidity % for the Leds to turn On</label>
                                    <div class="range-value form-label" id="range_humidity_label"></div>
                                    <input id="range_humidity" class="form-range" type="range" min="-100" max="100" value="0" step="1" oninput="showVal('range_humidity', ' %')">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkbox_lights">
                                    <label class="form-check-label" for="checkbox_lights">Lights Always Open</label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="range-wrap">
                                    <label for="range_water" class="form-label">Water % for the pump to start</label>
                                    <div class="range-value form-label" id="range_water_label"></div>
                                    <input id="range_water" class="form-range" type="range" min="-100" max="100" value="0" step="1" oninput="showVal('range_water', ' %')">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkbox_pump">
                                    <label class="form-check-label" for="checkbox_pump">Pump Always On</label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="range-wrap">
                                    <label for="range_wind" class="form-label">Wind % for the fan to open</label>
                                    <div class="range-value form-label" id="range_wind_label"></div>
                                    <input id="range_wind" class="form-range" type="range" min="-100" max="100" value="0" step="1" oninput="showVal('range_wind', '')">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkbox_fan">
                                    <label class="form-check-label" for="checkbox_fan">Fan Always On</label>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-6 col-md-4">
                                <div class="range-wrap">
                                    <label for="range_light" class="form-label">Light Lux for the ceiling to close</label>
                                    <div class="range-value form-label" id="range_light_label"></div>
                                    <input id="range_light" class="form-range" type="range" min="0" max="1000000" value="15000" step="2500" oninput="showVal('range_light', ' lux')">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkbox_fan">
                                    <label class="form-check-label" for="checkbox_fan">Fan Always On</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


                </main>
            </div>
        </div>

        <?=$this->fetch('./layout/footer.php')?>

        <script>
            document.addEventListener("DOMContentLoaded", startRangeInput());

            function startRangeInput() {
                showVal('range_temperature', ' ºC');
                showVal('range_humidity', ' %');
                showVal('range_water', ' %');
                showVal('range_wind', '');
                showVal('range_light', ' lux');
            }

            function showVal(name, unit){
                const range = document.getElementById(name);
                const range_label = document.getElementById(name + "_label" );
                const newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) );
                const newPosition = 10 - (newValue * 0.2);

                range_label.innerHTML = `<span>${range.value} ${unit}</span>`;
                range_label.style.left = `calc(${newValue}% + (${newPosition}px))`;
            }
        </script>
    </body>
</html>
