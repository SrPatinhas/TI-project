<?php
    if (empty($plants)) {
        echo $this->fetch('./components/no-data.php', ["type" => "plants"]);
    } else {
        echo "<div class='row row-cols-1 row-cols-md-4 g-4 mb-2 pb-4 border-bottom'>";
        foreach ($plants as $item) {
            echo $this->fetch('./components/plant-card.php', ["item" => $item]);
        }
        echo "</div>";
    }
?>