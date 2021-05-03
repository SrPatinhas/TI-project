<?php
    foreach ($plants as $item) {
        echo $this->fetch('./components/plant-card.php', ["item" => $item]);
    }
?>