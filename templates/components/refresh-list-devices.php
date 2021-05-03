<?php
    if (empty($devices)) {
        echo $this->fetch('./components/no-data.php', ["type" => "devices"]);
    } else {
        echo "<div class='row row-cols-1 row-cols-md-3 g-3 mb-2 pb-4 border-bottom'>";
        foreach ($devices as $item) {
            echo $this->fetch('./components/device-card.php', ["item" => $item]);
        }
        echo "</div>";
    }
?>