<?php
    foreach ($devices as $item) {
        echo $this->fetch('./components/device-card.php', ["item" => $item]);
    }
?>