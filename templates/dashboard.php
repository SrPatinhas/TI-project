<!doctype html>
<html lang="en">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "Dashboard"])?>
    </head>
    <body>
        <?=$this->fetch('./layout/menu.php', ["user" => $user])?>
        <div class="container-fluid">
            <div class="row">

                <?=$this->fetch('./layout/sidebar.php', ["user" => $user, "active" => "dashboard"])?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1>Dashboard</h1>
                        <a href="#" class="btn btn-primary" id="refresh-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                            </svg>
                            Auto Refresh: <span>Off</span>
                        </a>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                        <h4>Plants</h4>
                    </div>
                    <div id="plants-list">
                        <?=$this->fetch('./components/refresh-list-plants.php', ["plants" => $plants])?>
                    </div>
                    <?php if ($user["role"] != "user") { ?>
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                            <h4>Devices</h4>
                        </div>
                        <?=$this->fetch('./components/accordion-list-devices.php', ["devices_sensors" => $devices_sensors, "devices_actuators" => $devices_actuators, "devices_others" => $devices_others])?>
                    <?php } ?>
                </main>
            </div>
        </div>

        <?=$this->fetch('./layout/footer.php')?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            window.auto_refresh = false;

            <?php if ($user["role"] != "user") { ?>
            function refreshDevices() {
                // Set up our HTTP request
                var xhr_devices = new XMLHttpRequest();
                // Setup our listener to process completed requests
                xhr_devices.onload = function () {
                    // Process our return data
                    if (xhr_devices.status >= 200 && xhr_devices.status < 300) {
                        document.getElementById("devices-list").innerHTML = xhr_devices.response
                    }
                };
                // Create and send a GET request
                xhr_devices.open('GET', '/refresh-list/devices');
                xhr_devices.send();
            }
            $(".force_state").on("change", function (e) {
                let id = $(this).data("id");
                let label = ($(this).is(':checked') ? 'On' : 'Off');
                // Without jQuery
                fetch("/devices/update/" + id + "/state")
                    .then(data => {
                        $("#force_state_label_" + id).text(label);
                    });
            });
            $(".change_active").on("change", function (e) {
                let id = $(this).data("id");
                let label = ($(this).is(':checked') ? 'Active' : 'Disabled');
                // Without jQuery
                fetch("/devices/update/" + id + "/status")
                    .then(data => {
                        $("#change_active_label_" + id).text(label);
                    });
            });

            <?php } ?>

            function refreshPlants() {
                // Set up our HTTP request
                var xhr_devices = new XMLHttpRequest();
                // Setup our listener to process completed requests
                xhr_devices.onload = function () {
                    // Process our return data
                    if (xhr_devices.status >= 200 && xhr_devices.status < 300) {
                        document.getElementById("plants-list").innerHTML = xhr_devices.response;
                        refreshTooltips();
                    }
                };
                // Create and send a GET request
                xhr_devices.open('GET', '/refresh-list/plants');
                xhr_devices.send();
            }


            function autoReload() {
                if (window.auto_refresh) {
                    setTimeout(function () {
                        <?=($user["role"] != "user" ? 'refreshDevices();' : '')?>
                        refreshPlants();
                        autoReload();  // calling again after 5 seconds
                    }, 5000);
                }
            }
            document.addEventListener("DOMContentLoaded", function(event) {
                document.getElementById("refresh-button").addEventListener("click", function() {
                    window.auto_refresh = !window.auto_refresh;
                    document.getElementById("refresh-button").children[1].innerHTML = (window.auto_refresh ? "On" : "Off");
                    autoReload(); // calling the function for the first time
                });
                autoReload(); // calling the function for the first time
                refreshTooltips();
            });
            function refreshTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            }
        </script>
    </body>
</html>
