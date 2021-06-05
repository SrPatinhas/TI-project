<div id="devices-list" class="accordion">
    <?=$this->fetch('./components/refresh-list-devices.php', ["devices" => $devices_sensors, "type" => "sensors", "title" => "Sensors Grid"])?>
    <?=$this->fetch('./components/refresh-list-devices.php', ["devices" => $devices_actuators, "type" => "actuators", "title" => "Actuators Grid"])?>
    <?=$this->fetch('./components/refresh-list-devices.php', ["devices" => $devices_others, "type" => "others", "title" => "Others Grid"])?>
</div>