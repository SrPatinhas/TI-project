<div class="accordion-item">
    <h2 class="accordion-header" id="heading<?=$type?>">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$type?>" aria-expanded="false" aria-controls="collapse<?=$type?>">
            <?=$title ?>
        </button>
    </h2>
    <div id="collapse<?=$type?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$type?>">
        <div class="accordion-body">
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
        </div>
    </div>
</div>
